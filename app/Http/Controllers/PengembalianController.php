<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengembalian;
use App\Models\Peminjaman;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;

class PengembalianController extends Controller
{
    /**
     * Menampilkan daftar pengembalian
     */
    public function index()
    {
        $pengembalians = Pengembalian::with(['peminjaman.barang', 'peminjaman.user'])
            ->orderByDesc('created_at')
            ->get();

        return view('pengembalian.index', compact('pengembalians'));
    }

    /**
     * Menyetujui pengembalian
     */
    public function approve($id)
    {
        $pengembalian = Pengembalian::with('peminjaman.barang')->findOrFail($id);

        // Cek status pengembalian
        if ($pengembalian->status_pengembalian !== 'pending') {
            return redirect()->route('pengembalian.index')
                ->with('error', 'Hanya pengembalian dengan status pending yang dapat disetujui');
        }

        DB::beginTransaction();

        try {
            // Update status pengembalian
            $pengembalian->status_pengembalian = 'completed';
            $pengembalian->save();

            // Update status peminjaman jika semua barang dikembalikan
            $peminjaman = $pengembalian->peminjaman;
            if ($pengembalian->jumlah_dikembalikan == $peminjaman->jumlah) {
                $peminjaman->status = 'returned';
                $peminjaman->save();
            }

            // Kembalikan stok barang
            $barang = $peminjaman->barang;
            $barang->stok += $pengembalian->jumlah_dikembalikan;
            $barang->save();

            DB::commit();

            return redirect()->route('pengembalian.index')
                ->with('success', 'Pengembalian berhasil disetujui');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('pengembalian.index')
                ->with('error', 'Gagal menyetujui pengembalian: ' . $e->getMessage());
        }
    }

    /**
     * Menolak pengembalian
     */
    public function reject($id)
    {
        $pengembalian = Pengembalian::findOrFail($id);

        // Cek status pengembalian
        if ($pengembalian->status_pengembalian !== 'pending') {
            return redirect()->route('pengembalian.index')
                ->with('error', 'Hanya pengembalian dengan status pending yang dapat ditolak');
        }

        DB::beginTransaction();

        try {
            // Hapus pengembalian
            $pengembalian->delete();

            DB::commit();

            return redirect()->route('pengembalian.index')
                ->with('success', 'Pengembalian berhasil ditolak');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('pengembalian.index')
                ->with('error', 'Gagal menolak pengembalian: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan form untuk menandai pengembalian sebagai rusak
     */
    public function markDamageForm($id)
    {
        $pengembalian = Pengembalian::with(['peminjaman.barang', 'peminjaman.user'])->findOrFail($id);

        // Cek apakah pengembalian sudah ditandai rusak atau bukan pending
        if ($pengembalian->status_pengembalian !== 'pending') {
            return redirect()->route('pengembalian.index')
                ->with('error', 'Hanya pengembalian dengan status pending yang dapat ditandai rusak');
        }

        return view('pengembalian.mark-damage', compact('pengembalian'));
    }

    /**
     * Menandai pengembalian sebagai rusak dan menambahkan denda
     */
    public function markDamage(Request $request, $id)
    {
        $request->validate([
            'denda' => 'required|numeric|min:0',
            'keterangan' => 'required|string'
        ]);

        $pengembalian = Pengembalian::findOrFail($id);

        // Cek apakah pengembalian sudah ditandai rusak atau bukan pending
        if ($pengembalian->status_pengembalian !== 'pending') {
            return redirect()->route('pengembalian.index')
                ->with('error', 'Hanya pengembalian dengan status pending yang dapat ditandai rusak');
        }

        DB::beginTransaction();

        try {
            // Update status pengembalian
            $pengembalian->status_pengembalian = 'damaged';
            $pengembalian->denda = $request->denda;
            $pengembalian->keterangan = $request->keterangan;
            $pengembalian->save();

            // Update status peminjaman jika semua barang dikembalikan
            $peminjaman = $pengembalian->peminjaman;
            if ($pengembalian->jumlah_dikembalikan == $peminjaman->jumlah) {
                $peminjaman->status = 'returned';
                $peminjaman->save();
            }

            // Kembalikan stok barang
            $barang = $peminjaman->barang;
            $barang->stok += $pengembalian->jumlah_dikembalikan;
            $barang->save();

            DB::commit();

            return redirect()->route('pengembalian.index')
                ->with('success', 'Pengembalian berhasil ditandai rusak dan denda ditambahkan');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('pengembalian.index')
                ->with('error', 'Gagal menandai pengembalian rusak: ' . $e->getMessage());
        }
    }
}
