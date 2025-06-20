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
    .form-label {
        font-weight: 600;
        color: #5a0050;
    }
    .btn-pink {
        background-color: rgb(189, 2, 152);
        color: white;
    }
    .btn-pink:hover {
        background-color: rgb(150, 0, 120);
        color: white;
    }
</style>

<div class="card shadow-sm">
    <div class="card-header">
        <h4 class="mb-0">Form Denda Kerusakan</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('pengembalian.updateDamaged', $pengembalian->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nama Peminjam</label>
                <input type="text" class="form-control" value="{{ $pengembalian->peminjaman->nama_peminjam ?? '-' }}" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Barang</label>
                <input type="text" class="form-control" value="{{ $pengembalian->peminjaman->barang->nama_barang ?? '-' }}" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Denda Keterlambatan</label>
                <input type="text" class="form-control" value="Rp{{ number_format($pengembalian->denda_keterlambatan, 0, ',', '.') }}" readonly>
            </div>

            <div class="mb-3">
                <label for="denda" class="form-label">Denda Kerusakan</label>
                <input type="number" name="denda" id="denda" class="form-control @error('denda') is-invalid @enderror" required min="0">
                @error('denda')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('pengembalian.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-pink">
                    <i class="fas fa-check me-1"></i> Simpan Denda
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
