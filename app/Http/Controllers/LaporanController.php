<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use Barryvdh\DomPDF\Facade\Pdf; // pastikan sudah install barryvdh/laravel-dompdf

class LaporanController extends Controller
{
    // Tampilkan halaman laporan
    public function peminjaman(Request $request)
    {
        $query = Peminjaman::with(['barang', 'user']);

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('tanggal_pinjam', [$request->from, $request->to]);
        }

        $peminjamans = $query->orderBy('tanggal_pinjam', 'desc')->get();

        return view('laporan.peminjaman', compact('peminjamans'));
    }

    // Export ke PDF
    public function peminjamanPdf(Request $request)
    {
        $query = Peminjaman::with(['barang', 'user']);

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('tanggal_pinjam', [$request->from, $request->to]);
        }

        $peminjamans = $query->orderBy('tanggal_pinjam', 'desc')->get();

        $pdf = PDF::loadView('laporan.pdf_peminjaman', compact('peminjamans'));
        return $pdf->download('laporan_peminjaman.pdf');
    }
}
