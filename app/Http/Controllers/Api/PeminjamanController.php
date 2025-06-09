<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use App\Models\Barang;

class PeminjamanController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'barang_id' => 'required|exists:barangs,id',
            'nama_peminjam' => 'required|string|max:255',
            'alasan_meminjam' => 'required|string|max:500',
            'jumlah' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        $validated['status'] = 'pending'; // Status default

        $barang = Barang::findOrFail($validated['barang_id']);

        // Cek stok barang
        if ($barang->stok < $validated['jumlah']) {
            return response()->json([
                'message' => 'Stok barang tidak mencukupi',
            ], 400);
        }

        // Kurangi stok barang
        $barang->stok -= $validated['jumlah'];
        $barang->save();

        // Simpan data peminjaman
        $peminjaman = Peminjaman::create($validated);

        // Load relasi barang dan user agar lengkap saat response
        $peminjaman->load(['barang', 'user']);

        return response()->json([
            'message' => 'Peminjaman berhasil ditambahkan',
            'data' => [
                'id' => $peminjaman->id,
                'nama_peminjam' => $peminjaman->nama_peminjam,
                'alasan_meminjam' => $peminjaman->alasan_meminjam,
                'jumlah' => $peminjaman->jumlah,
                'tanggal_pinjam' => $peminjaman->tanggal_pinjam,
                'tanggal_kembali' => $peminjaman->tanggal_kembali,
                'status' => $peminjaman->status,
                'barang' => [
                    'id' => $peminjaman->barang->id,
                    'namaBarang' => $peminjaman->barang->namaBarang,
                    'stok' => $peminjaman->barang->stok,
                ],
                'user' => [
                    'id' => $peminjaman->user->id,
                    'name' => $peminjaman->user->name,
                ],
            ],
        ], 201);
    }

    // Ambil data peminjaman user yang sedang login
    public function getByUser(Request $request)
    {
        $user = $request->user();
        $peminjamans = Peminjaman::with('barang')
            ->where('user_id', $user->id)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $peminjamans,
        ]);
    }

    // Ambil semua data peminjaman (misal untuk admin)
    public function index()
    {
        $peminjamans = Peminjaman::with(['barang', 'user'])->get();

        return response()->json([
            'success' => true,
            'data' => $peminjamans,
        ]);
    }
}
