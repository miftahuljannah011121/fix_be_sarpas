@extends('layouts.app')

@section('content')
<style>
    .card {
        background-color: #fff0f8;
        color: #5a0050;
        border: none;
        box-shadow: 0 0 12px rgba(189, 2, 152, 0.15);
    }

    .card-header {
        background-color: rgb(189, 2, 152);
        color: #fff;
        font-weight: bold;
        font-size: 1.2rem;
    }

    .table thead {
        background-color: #ffe2f0;
        color: #5a0050;
        font-size: 0.95rem;
    }

    .badge-status {
        font-size: 0.8rem;
        padding: 5px 10px;
        border-radius: 12px;
        font-weight: 600;
    }

    .badge-warning-custom {
        background-color: #fff0c1;
        color: #7d5700;
    }

    .badge-success-custom {
        background-color: #c0f5d3;
        color: #05633b;
    }

    .badge-danger-custom {
        background-color: #f6c1e5;
        color: #85004c;
    }

    .btn-action {
        font-size: 0.85rem;
        padding: 6px 12px;
    }
</style>

<div class="card shadow-sm">
    <div class="card-header">
        <i class="fas fa-undo-alt me-2"></i> Daftar Pengembalian
    </div>

    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Peminjam</th>
                        <th>Barang</th>
                        <th>Foto</th>
                        <th>Jumlah</th>
                        <th>Kondisi</th> <!-- Tambahan kolom -->
                        <th>Tgl Kembali</th>
                        <th>Total Denda</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengembalians as $pengembalian)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <strong>{{ $pengembalian->peminjaman->nama_peminjam ?? '-' }}</strong><br>
                                <small class="text-muted">{{ $pengembalian->user->name ?? '-' }}</small>
                            </td>
                            <td>{{ $pengembalian->peminjaman->barang->nama_barang ?? '-' }}</td>
                            <td>
                                @if($pengembalian->peminjaman->barang?->foto)
                                    <img src="{{ asset('storage/' . $pengembalian->peminjaman->barang->foto) }}"
                                         class="img-thumbnail rounded" style="max-height: 60px;" alt="Foto Barang">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $pengembalian->jumlah }}</td>
                            <td>{{ ucfirst($pengembalian->kondisi_barang ?? '-') }}</td> <!-- Data kondisi -->
                            <td>{{ $pengembalian->tanggal_dikembalikan ?? '-' }}</td>
                            <td>Rp{{ number_format($pengembalian->total_denda, 0, ',', '.') }}</td>
                            <td>
                                @php
                                    $badgeClass = match(strtolower($pengembalian->status)) {
                                        'pending' => 'badge-warning-custom',
                                        'completed' => 'badge-success-custom',
                                        'damage' => 'badge-danger-custom',
                                        default => 'bg-secondary'
                                    };
                                    $badgeText = match(strtolower($pengembalian->status)) {
                                        'pending' => 'Menunggu',
                                        'completed' => 'Selesai',
                                        'damage' => 'Rusak',
                                        default => ucfirst($pengembalian->status)
                                    };
                                @endphp
                                <span class="badge badge-status {{ $badgeClass }}">{{ $badgeText }}</span>
                            </td>
                            <td>
                                @if (strtolower($pengembalian->status) === 'pending')
                                    <div class="d-flex flex-column gap-1">
                                        <form action="{{ route('pengembalian.approve', $pengembalian->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-action w-100">
                                                <i class="fas fa-check me-1"></i> Approve
                                            </button>
                                        </form>
                                        <a href="{{ route('pengembalian.denda', $pengembalian->id) }}"
                                           class="btn btn-danger btn-action w-100">
                                            <i class="fas fa-exclamation-triangle me-1"></i> Tandai Rusak
                                        </a>
                                    </div>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted">Belum ada data pengembalian.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
