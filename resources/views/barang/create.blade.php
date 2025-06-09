@extends('layouts.app')

@section('content')
    <style>
        .card {
            background-color: #fff0f8;
            color: #5a0050;
            border: none;
        }

        .card-header {
            background-color: rgb(189, 2, 152);
            color: #fff;
        }

        .form-control, .form-select {
            border: 1px solid #ce68ae;
        }

        .btn-success {
            background-color: rgb(255, 0, 191);
            border: none;
            color: white;
        }

        .btn-success:hover {
            background-color: rgb(220, 0, 160);
        }

        .btn-secondary {
            background-color: #e0d0dc;
            color: #5a0050;
        }

        .alert-danger {
            background-color: #ffd1ec;
            color: #5a0050;
        }
    </style>

    <div class="card shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Tambah Barang</h4>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="nama_barang" class="form-label">Nama Barang</label>
                    <input type="text" class="form-control" id="nama_barang" name="nama_barang"
                        value="{{ old('nama_barang') }}" required>
                </div>

                <div class="mb-3">
                    <label for="kategori_id" class="form-label">Kategori</label>
                    <select class="form-select" id="kategori_id" name="kategori_id" required>
                        <option value="" disabled selected>Pilih Kategori</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="stok" class="form-label">Stok</label>
                    <input type="number" class="form-control" id="stok" name="stok"
                        value="{{ old('stok') }}" min="0" required>
                </div>

                <div class="mb-3">
                    <label for="foto" class="form-label">Foto</label>
                    <input type="file" class="form-control" id="foto" name="foto">
                    <div class="form-text">Format: JPG, JPEG, PNG (Maks. 2MB)</div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="{{ route('barang.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
