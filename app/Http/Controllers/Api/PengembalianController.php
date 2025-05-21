<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengembalian;
use App\Models\Peminjaman;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PengembalianController extends Controller
{
    /**
     * Menyimpan data pengembalian baru
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'peminjaman_id' => 'required|exists:peminjamans,id',
            'tanggal_pengembalian' => 'required|date',
            'jumlah_dikembalikan' => 'required|integer|min:1',
            'status_pengembalian' => 'required|in:pending,completed,damaged',
            'keterangan' => 'nullable|string',
            'denda' => 'nullable|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        // Cek peminjaman
        $peminjaman = Peminjaman::with('barang')->find($request->peminjaman_id);

        if (!$peminjaman) {
            return response()->json([
                'success' => false,
                'message' => 'Peminjaman tidak ditemukan'
            ], 404);
        }

        // Cek status peminjaman
        if ($peminjaman->status !== 'approved') {
            return response()->json([
                'success' => false,
                'message' => 'Peminjaman belum disetujui atau sudah dikembalikan'
            ], 400);
        }

        // Cek jumlah pengembalian
        if ($request->jumlah_dikembalikan > $peminjaman->jumlah) {
            return response()->json([
                'success' => false,
                'message' => 'Jumlah pengembalian melebihi jumlah peminjaman'
            ], 400);
        }

        DB::beginTransaction();

        try {
            // Simpan data pengembalian
            $pengembalian = Pengembalian::create([
                'peminjaman_id' => $request->peminjaman_id,
                'tanggal_pengembalian' => $request->tanggal_pengembalian,
                'jumlah_dikembalikan' => $request->jumlah_dikembalikan,
                'status_pengembalian' => $request->status_pengembalian,
                'keterangan' => $request->keterangan,
                'denda' => $request->denda ?? 0
            ]);

            // Update status peminjaman jika semua barang dikembalikan
            if ($request->jumlah_dikembalikan == $peminjaman->jumlah) {
                $peminjaman->status = 'returned';
                $peminjaman->save();
            }

            // Kembalikan stok barang
            $barang = $peminjaman->barang;
            $barang->stok += $request->jumlah_dikembalikan;
            $barang->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pengembalian berhasil disimpan',
                'data' => $pengembalian
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan pengembalian',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
    
