<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Barang;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with(['barang', 'user'])
            ->orderByDesc('created_at')
            ->get();
        

        return view('peminjaman.index', compact('peminjamans'));
    }

    public function approve($id)
    {
        $peminjaman = Peminjaman::with('barang')->findOrFail($id);
        $barang = $peminjaman->barang;

        // Pastikan barang ditemukan
        if (!$barang) {
            Log::error("Barang tidak ditemukan untuk peminjaman ID: {$id}");
            return redirect()->route('peminjaman.index')
                ->with('error', 'Barang tidak ditemukan!');
        }

        // Log informasi barang
        Log::info("Barang ditemukan: ID={$barang->id}, Nama={$barang->nama_barang}, Stok={$barang->stok}");

        // Cek apakah stok mencukupi
        if ($barang->stok < $peminjaman->jumlah) {
            return redirect()->route('peminjaman.index')
                ->with('error', 'Stok barang tidak mencukupi! Stok tersedia: ' . $barang->stok);
        }

        // Gunakan transaction untuk memastikan konsistensi data
        DB::beginTransaction();

        try {
            // Update status peminjaman dan kurangi stok barang
            $peminjaman->status = 'approved';

            // Kurangi stok barang
            $stokAwal = $barang->stok;
            $stokBaru = $stokAwal - $peminjaman->jumlah;

            // Coba update langsung via query builder untuk memastikan
            $updated = DB::table('barangs')
                ->where('id', $barang->id)
                ->update(['stok' => $stokBaru]);

                

            Log::info("Update stok via query builder: " . ($updated ? "Berhasil ({$updated} baris)" : "Gagal"));

            // Update juga model untuk konsistensi
            $barang->stok = $stokBaru;

            // Log perubahan stok untuk debugging
            Log::info("Peminjaman ID: {$peminjaman->id} - Stok barang {$barang->nama_barang} berkurang dari {$stokAwal} menjadi {$barang->stok}");

            // Simpan perubahan
            $barangSaved = $barang->save();
            $peminjamanSaved = $peminjaman->save();

            // Log hasil save
            Log::info("Hasil save - Barang: " . ($barangSaved ? 'Berhasil' : 'Gagal') .
                      ", Peminjaman: " . ($peminjamanSaved ? 'Berhasil' : 'Gagal'));

            DB::commit();

            return redirect()->route('peminjaman.index')
                ->with('success', 'Peminjaman berhasil disetujui!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('peminjaman.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function reject($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->status = 'rejected';
        $peminjaman->save();

        return redirect()->route('peminjaman.index')
        ->with('success', 'Peminjaman berhasil ditolak!');
    }
}
