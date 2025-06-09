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

        .form-control {
            border-color: rgb(189, 2, 152);
        }

        .btn-primary {
            background-color: rgb(255, 0, 191);
            border: none;
        }

        .btn-primary:hover {
            background-color: rgb(220, 0, 160);
        }
    </style>

    <div class="card">
        <div class="card-header">
            <h4>Tambah Kategori</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('kategori.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Kategori</label>
                    <input type="text" name="nama" id="nama" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
@endsection
