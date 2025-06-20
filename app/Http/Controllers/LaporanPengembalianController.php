<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanPengembalianController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengembalian::with(['peminjaman.user', 'peminjaman.barang']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('tanggal_dikembalikan', [$request->from, $request->to]);
        }

        $pengembalians = $query->latest()->paginate(10);

        return view('laporan.pengembalian', compact('pengembalians'));
    }

    public function export(Request $request)
    {
        $query = Pengembalian::with(['peminjaman.user', 'peminjaman.barang']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('tanggal_dikembalikan', [$request->from, $request->to]);
        }

        $pengembalians = $query->latest()->get();

        $pdf = PDF::loadView('laporan.pengembalian-pdf', compact('pengembalians'));
        return $pdf->download('laporan-pengembalian.pdf');
    }
}
