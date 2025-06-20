<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function index()
    {
        $pengembalians = Pengembalian::with(['peminjaman', 'user'])->latest()->get();
        return view('pengembalian.index', compact('pengembalians'));
    }

   public function approve($id)
{
    $pengembalian = Pengembalian::findOrFail($id);

    if ($pengembalian->status !== 'pending') {
        return redirect()->route('pengembalian.index')
            ->with('error', 'Pengembalian ini sudah diproses.');
    }

    $dendaTerlambat = $pengembalian->denda_keterlambatan;
    if ($dendaTerlambat > 0) {
        $pengembalian->update(['denda' => $dendaTerlambat]);
    }

    $pengembalian->update(['status' => 'completed']);  // ganti dari 'complete'

    $peminjaman = $pengembalian->peminjaman;
    $peminjaman->update(['status' => 'returned']);  // ganti dari 'dikembalikan' atau 'rejected'

    $barang = $peminjaman->barang;
    if ($barang) {
        $barang->increment('jumlah', $pengembalian->jumlah);
    }

    return redirect()->route('pengembalian.index')->with('success', 'Pengembalian berhasil disetujui.');
}

public function reject($id)
{
    $pengembalian = Pengembalian::findOrFail($id);

    $pengembalian->update(['status' => 'damage']);  // sudah cocok

    $peminjaman = $pengembalian->peminjaman;
    $peminjaman->update(['status' => 'dikembalikan']);  // ganti dari 'rejected'

    $barang = $peminjaman->barang;
    if ($barang) {
        $barang->decrement('stok', $pengembalian->jumlah); // pastikan kolom stok/ jumlah benar
    }

    return redirect()->route('pengembalian.index')->with('success', 'Pengembalian barang rusak berhasil ditandai.');
}

    public function markDamaged($id)
    {
        $pengembalian = Pengembalian::findOrFail($id);
        return view('pengembalian.denda', compact('pengembalian'));
    }

   public function updateDamaged(Request $request, $id)
{
    $validated = $request->validate([
        'denda' => 'required|numeric|min:0',
    ]);

    $pengembalian = Pengembalian::findOrFail($id);

    $dendaTerlambat = $pengembalian->denda_keterlambatan;
    $totalDendaRusak = $validated['denda'];

    $pengembalian->update([
        'status' => 'damage', // sudah cocok
        'denda' => $totalDendaRusak + $dendaTerlambat,
    ]);

    $peminjaman = $pengembalian->peminjaman;
    $peminjaman->update(['status' => 'dikembalikan']);  // ganti dari 'rejected'

    $barang = $peminjaman->barang;
    if ($barang) {
        $barang->increment('jumlah', $pengembalian->jumlah);
    }

    return redirect()->route('pengembalian.index')->with('success', 'Denda pengembalian rusak berhasil diperbarui.');
}
}