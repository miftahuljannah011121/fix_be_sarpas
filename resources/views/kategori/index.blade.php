@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-xl shadow-md p-6 mt-8">
    <h1 class="text-3xl font-semibold mb-6 text-gray-800 border-b pb-2">Daftar Kategori</h1>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 border border-green-300 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('kategori.create') }}" class="mb-4 inline-block bg-blue-600 text-black px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition-all">
        + Tambah Kategori   
    </a>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-sm">
            <thead class="bg-gray-100 text-gray-700 uppercase text-sm">
                <tr>
                    <th class="px-4 py-3 border">id</th>
                    <th class="px-4 py-3 border text-left">Nama</th>
                    <th class="px-4 py-3 border text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kategoris as $kategori)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border text-center">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 border">{{ $kategori->nama }}</td>
                        <td class="px-4 py-2 border text-center space-x-2">
                            <a href="{{ route('kategori.edit', $kategori) }}" class="inline-block px-3 py-1 bg-yellow-400 text-black text-sm rounded hover:bg-black-500 transition">Edit</a>
                            <form action="{{ route('kategori.destroy', $kategori) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus kategori ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 bg-red-500 text-pink text-sm rounded hover:bg-red-600 transition">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-4 py-6 text-center text-gray-500">Belum ada kategori.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
