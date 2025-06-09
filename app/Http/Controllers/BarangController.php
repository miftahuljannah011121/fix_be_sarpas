<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    // Tampilkan semua barang
    public function index()
    {
        $barangs = Barang::with('kategori')->get();
        return view('barang.index', compact('barangs'));
    }

    // Tampilkan form tambah barang
    public function create()
    {
        $kategoris = Kategori::all();
        return view('barang.create', compact('kategoris'));
    }

    // Simpan barang baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'stok' => 'required|integer|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['nama_barang', 'kategori_id', 'stok']);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('uploads', 'public'); // Simpan ke storage/app/public/uploads
        }

        Barang::create($data);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan');
    }

    // Tampilkan form edit barang
    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        $kategoris = Kategori::all();
        return view('barang.edit', compact('barang', 'kategoris'));
    }

    // Update barang
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'stok' => 'required|integer|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $barang = Barang::findOrFail($id);
        $data = $request->only(['nama_barang', 'kategori_id', 'stok']);

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($barang->foto && Storage::disk('public')->exists($barang->foto)) {
                Storage::disk('public')->delete($barang->foto);
            }
            $data['foto'] = $request->file('foto')->store('uploads', 'public');
        }

        $barang->update($data);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diupdate');
    }

    // Hapus barang
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);

        if ($barang->foto && Storage::disk('public')->exists($barang->foto)) {
            Storage::disk('public')->delete($barang->foto);
        }

        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus');
    }
}
