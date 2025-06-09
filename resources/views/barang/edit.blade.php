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

        .img-thumbnail {
            border: 2px solid rgb(189, 2, 152);
        }
    </style>

    <div class="card shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Edit Barang</h4>
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

            <form action="{{ route('barang.update', $barang) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nama_barang" class="form-label">Nama Barang</label>
                    <input type="text" class="form-control" id="nama_barang" name="nama_barang"
                        value="{{ old('nama_barang', $barang->nama_barang) }}" required>
                </div>

                <div class="mb-3">
                    <label for="kategori_id" class="form-label">Kategori</label>
                    <select class="form-select" id="kategori_id" name="kategori_id" required>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ (old('kategori_id', $barang->kategori_id) == $kategori->id) ? 'selected' : '' }}>
                                {{ $kategori->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="stok" class="form-label">Stok</label>
                    <input type="number" class="form-control" id="stok" name="stok"
                        value="{{ old('stok', $barang->stok) }}" min="0" required>
                </div>

                <div class="mb-3">
                    <label for="foto" class="form-label">Foto</label>
                    @if($barang->foto)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $barang->foto) }}" alt="Foto Barang" class="img-thumbnail" style="height: 100px;">
                        </div>
                    @endif
                    <input type="file" class="form-control" id="foto" name="foto">
                    <div class="form-text">Format: JPG, JPEG, PNG (Maks. 2MB)</div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                    <a href="{{ route('barang.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
