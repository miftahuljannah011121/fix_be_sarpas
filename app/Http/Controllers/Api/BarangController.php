<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::with('kategori')->get();

        $formatted = $barangs->map(function ($barang) {
            return [
                'id' => $barang->id,
                'nama_barang' => $barang->nama_barang,
                'stok' => $barang->stok,
                'kategori' => $barang->kategori->nama_kategori ?? '-', // pastikan field-nya benar
                'foto' => $barang->foto ? asset('storage/' . $barang->foto) : null,
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Data barang berhasil diambil',
            'data' => $formatted
        ]);
    }
}
