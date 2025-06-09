@extends('layouts.app')

@section('content')
<style>
    .card {
        background-color: #fff0f8;
        color: #5a0050;
        border: none;
        box-shadow: 0 0 10px rgba(189, 2, 152, 0.2);
    }

    .card-header {
        background-color: rgb(189, 2, 152);
        color: #fff;
    }

    .table {
        color: #5a0050;
    }

    .table thead {
        background-color: rgb(255, 182, 232);
    }

    .btn-success {
        background-color: rgb(255, 0, 191);
        color: #fff;
        border: none;
    }

    .btn-success:hover {
        background-color: rgb(220, 0, 160);
    }

    .btn-warning {
        background-color: rgb(255, 182, 232);
        color: #5a0050;
        border: none;
    }

    .btn-warning:hover {
        background-color: rgb(235, 152, 202);
    }

    .btn-danger {
        background-color: rgb(189, 2, 152);
        color: #fff;
        border: none;
    }

    .btn-danger:hover {
        background-color: rgb(159, 1, 127);
    }

    .alert-success {
        background-color: rgb(255, 182, 232);
        color: #5a0050;
    }

    .img-thumbnail {
        border: 2px solid rgb(189, 2, 152);
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
    }
</style>

<div class="card shadow-sm">
    <div class="card-header">
        <h4 class="mb-0">Daftar Barang</h4>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('barang.create') }}" class="btn btn-success mb-3">
            <i class="bi bi-plus-circle"></i> Tambah Barang
        </a>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 30%;">Nama Barang</th>
                        <th style="width: 10%;">Stok</th>
                        <th style="width: 20%;">Kategori</th>
                        <th style="width: 15%;">Foto</th>
                        <th style="width: 20%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($barangs as $barang)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-start">{{ $barang->nama_barang }}</td>
                            <td>{{ $barang->stok }}</td>
                            <td>{{ $barang->kategori->nama ?? '-' }}</td>
                            <td>
    @if($barang->foto)
    <img src="{{ asset('storage/' . $barang->foto) }}" alt="Foto Barang" class="img-thumbnail">

    @else
        <span class="text-muted">Tidak ada foto</span>
    @endif
</td>
                            <td>
                                <a href="{{ route('barang.edit', $barang) }}" class="btn btn-sm btn-warning me-1">
                                    Edit
                                </a>
                                <form action="{{ route('barang.destroy', $barang) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Yakin ingin menghapus barang ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-3 text-muted">Belum ada data barang.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
