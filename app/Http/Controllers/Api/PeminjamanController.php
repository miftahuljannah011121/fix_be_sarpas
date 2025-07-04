<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use App\Models\Barang;

class PeminjamanController extends Controller
{
    // Simpan peminjaman dari user (stok belum dikurangi)
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

        // Cek stok cukup atau tidak, tapi jangan dikurangi di sini
        if ($barang->stok < $validated['jumlah']) {
            return response()->json([
                'message' => 'Stok barang tidak mencukupi',
            ], 400);
        }

        // Simpan peminjaman (belum menyentuh stok barang)
        $peminjaman = Peminjaman::create($validated);

        // Load relasi untuk response
        $peminjaman->load(['barang', 'user']);

        return response()->json([
            'message' => 'Peminjaman berhasil ditambahkan (menunggu persetujuan admin)',
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

    // Ambil data peminjaman milik user yang sedang login
    public function getByUser(Request $request)
    {
        $user = $request->user();
        $peminjamans = Peminjaman::with('barang')
            ->where('user_id', $user->id)
            ->get();

        return response()->json([
           
            'data' => $peminjamans,
        ]);
    }

    // Ambil daftar peminjaman user yang belum dikembalikan dan disetujui
public function belumDikembalikan($user_id)
{
    $peminjamans = Peminjaman::with('barang')
        ->where('user_id', $user_id)
        ->where('status', 'approved') // hanya yang sudah disetujui
        ->whereDoesntHave('pengembalian') // belum dikembalikan
        ->get();

    return response()->json([
        'data' => $peminjamans,
    ]);
}


    // Ambil semua data peminjaman (misalnya untuk admin)
    public function index()
    {
        $peminjamans = Peminjaman::with(['barang', 'user'])->get();

        return response()->json([
            'success' => true,
            'data' => $peminjamans,
        ]);
    }
}
