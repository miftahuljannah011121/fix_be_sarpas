<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Barang;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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
            $barang->stok -= $peminjaman->jumlah;

            // Simpan perubahan
            $barang->save();
            $peminjaman->save();

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
