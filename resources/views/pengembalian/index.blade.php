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

    .btn-danger {
        background-color: rgb(189, 2, 152);
        color: #fff;
        border: none;
    }

    .btn-danger:hover {
        background-color: rgb(159, 1, 127);
    }

    .btn-warning {
        background-color: rgb(255, 182, 232);
        color: #5a0050;
        border: none;
    }

    .btn-warning:hover {
        background-color: rgb(219, 145, 191);
        color: #3e0033;
    }

    .alert-success {
        background-color: rgb(255, 182, 232);
        color: #5a0050;
    }

    .alert-danger {
        background-color: rgb(220, 180, 210);
        color: #5a0050;
    }

    .badge-pink {
        background-color: rgb(255, 0, 191);
        color: white;
    }

    .badge-warning-custom {
        background-color: rgb(255, 182, 232);
        color: #5a0050;
    }

    .badge-success-custom {
        background-color: rgb(0, 180, 102);
        color: white;
    }

    .badge-danger-custom {
        background-color: rgb(189, 2, 152);
        color: white;
    }

    .text-muted {
        color: #9e6e9a !important;
    }
</style>

<div class="card shadow-sm">
    <div class="card-header">
        <h4 class="mb-0">Daftar Pengembalian</h4>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success mb-4">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger mb-4">{{ session('error') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Peminjam</th>
                        <th>Barang</th>
                        <th>Foto</th>
                        <th>Jumlah Dikembalikan</th>
                        <th>Tanggal Pengembalian</th>
                        <th>Status</th>
                        <th>Denda</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengembalians as $pengembalian)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                {{ $pengembalian->peminjaman->nama_peminjam ?? 'Tidak tersedia' }}<br>
                                <small class="text-muted">{{ $pengembalian->peminjaman->user->name ?? '-' }}</small>
                            </td>
                            <td>{{ $pengembalian->peminjaman->barang->nama_barang ?? '-' }}</td>
                            <td class="text-center">
                                @if($pengembalian->peminjaman->barang && $pengembalian->peminjaman->barang->foto)
                                    <img src="{{ asset('storage/' . $pengembalian->peminjaman->barang->foto) }}"
                                         class="img-thumbnail" style="max-height: 65px;" alt="Foto Barang">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $pengembalian->jumlah_dikembalikan }}</td>
                            <td>{{ $pengembalian->tanggal_pengembalian }}</td>
                            <td>
                                @php
                                    $status = $pengembalian->status_pengembalian;
                                    $badgeClass = match($status) {
                                        'pending' => 'badge-warning-custom',
                                        'completed' => 'badge-success-custom',
                                        'damaged' => 'badge-danger-custom',
                                        default => 'bg-secondary',
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }}">
                                    {{ ucfirst($status == 'completed' ? 'Selesai' : ($status == 'pending' ? 'Menunggu' : 'Rusak')) }}
                                </span>
                            </td>
                            <td>
                                @if($pengembalian->denda > 0)
                                    <span class="text-danger">Rp {{ number_format($pengembalian->denda, 0, ',', '.') }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($pengembalian->status_pengembalian == 'pending')
                                    <form action="{{ route('pengembalian.approve', $pengembalian->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success"
                                            onclick="return confirm('Setujui pengembalian ini?')">Setujui</button>
                                    </form>
                                    <form action="{{ route('pengembalian.reject', $pengembalian->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Tolak pengembalian ini?')">Tolak</button>
                                    </form>
                                    <a href="{{ route('pengembalian.markDamage.form', $pengembalian->id) }}" 
                                       class="btn btn-sm btn-warning mt-1">Tandai Rusak</a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="9" class="text-center py-3 text-muted">Belum ada data pengembalian.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
