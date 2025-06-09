@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-danger text-white">
        <h4 class="mb-0">Tandai Pengembalian Rusak</h4>
    </div>
    <div class="card-body">
        @if(session('error'))
            <div class="alert alert-danger mb-4">{{ session('error') }}</div>
        @endif

        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Informasi Pengembalian</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <th>Peminjam</th>
                                <td>{{ $pengembalian->peminjaman->nama_peminjam }}</td>
                            </tr>
                            <tr>
                                <th>Barang</th>
                                <td>{{ $pengembalian->peminjaman->barang->nama_barang ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Foto Barang</th>
                                <td>
                                    @if($pengembalian->peminjaman->barang->foto)
                                        <img src="{{ asset('storage/' . $pengembalian->peminjaman->barang->foto) }}" class="img-thumbnail" style="max-height: 100px;">
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Jumlah Dikembalikan</th>
                                <td>{{ $pengembalian->jumlah_dikembalikan }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Pengembalian</th>
                                <td>{{ $pengembalian->tanggal_pengembalian }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('pengembalian.markDamage', $pengembalian->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="denda" class="form-label">Denda (Rp)</label>
                <input type="number" name="denda" id="denda" class="form-control @error('denda') is-invalid @enderror"
                    value="{{ old('denda', 0) }}" min="0" required>
                @error('denda')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Masukkan jumlah denda yang harus dibayar.</div>
            </div>

            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan Kerusakan</label>
                <textarea name="keterangan" id="keterangan" rows="4"
                    class="form-control @error('keterangan') is-invalid @enderror"
                    required>{{ old('keterangan') }}</textarea>
                @error('keterangan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Jelaskan detail kerusakan pada barang.</div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-danger">Simpan</button>
                <a href="{{ route('pengembalian.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
