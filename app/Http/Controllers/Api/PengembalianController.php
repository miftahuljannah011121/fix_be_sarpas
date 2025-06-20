<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengembalian;
use App\Models\Peminjaman;
use App\Models\Barang;
use Carbon\Carbon;

class PengembalianApiController extends Controller
{
    // Menyimpan data pengembalian
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'peminjaman_id' => 'required|exists:peminjamans,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_dikembalikan' => 'required|date',
            'kondisi_barang' => 'required|string|max:255',
          'status' => 'required|in:pending,completed,damage,returned',

        ]);

        // Cari data peminjaman terkait beserta barangnya
        $peminjaman = Peminjaman::with('barang')->findOrFail($validated['peminjaman_id']);

        // Cek status peminjaman
        if ($peminjaman->status === 'dikembalikan') {
            return response()->json([
                'success' => false,
                'message' => 'Peminjaman ini sudah dikembalikan.'
            ], 400);
        }

        if ($peminjaman->status !== 'disetujui') {
            return response()->json([
                'success' => false,
                'message' => 'Peminjaman belum disetujui admin.'
            ], 400);
        }

     

        // Simpan data pengembalian
        $pengembalian = Pengembalian::create([
            'user_id' => $validated['user_id'],
            'peminjaman_id' => $validated['peminjaman_id'],
            'jumlah' => $validated['jumlah'],
            'tanggal_dikembalikan' => $validated['tanggal_dikembalikan'],
            'kondisi_barang' => $validated['kondisi_barang'],
            'denda' => $validated['denda'] ?? 0,
            'status' => 'pending',
        ]);

        // Update stok barang (increment stok sesuai jumlah pengembalian)
        if ($peminjaman->barang) {
            $peminjaman->barang->increment('jumlah', $validated['jumlah']);
        }

        // Update status peminjaman menjadi returned
        $peminjaman->update(['status' => 'dikembalikan']);

        return response()->json([
            'success' => true,
            'message' => 'Pengembalian berhasil dicatat.',
            'data' => $pengembalian,
        ], 201);
    }

    // Menampilkan semua data pengembalian
    public function index()
    {
        $pengembalians = Pengembalian::with(['peminjaman.barang', 'user'])->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $pengembalians,
        ]);
    }

    // Menampilkan detail pengembalian berdasarkan ID
    public function show($id)
    {
        $pengembalian = Pengembalian::with(['peminjaman.barang', 'user'])->find($id);

        if (!$pengembalian) {
            return response()->json([
                'success' => false,
                'message' => 'Data pengembalian tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $pengembalian,
        ]);
    }

    // Menampilkan peminjaman yang belum dikembalikan (status approved)
    public function getPeminjamanBelumDikembalikan()
    {
        $peminjamans = Peminjaman::with('barang')
            ->where('status', 'disetujui')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $peminjamans,
        ]);
    }
}
