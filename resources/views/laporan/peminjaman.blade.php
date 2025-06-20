@extends('layouts.app')

@section('content')
<style>
    .card-header {
        background: linear-gradient(to right, #ffb6e8, #bd0298);
        color: white;
        font-weight: bold;
        font-size: 1.1rem;
        border: none;
    }

    .table thead {
        background-color: #ffe6f2;
        color: #5a0050;
    }

    .table tbody tr:hover {
        background-color: #fff5fc;
    }

    .badge-status {
        font-size: 0.85rem;
        padding: 5px 10px;
        border-radius: 10px;
        font-weight: 500;
    }

    .badge-pending {
        background-color: #ffe6cc;
        color: #d9480f;
    }

    .badge-approved {
        background-color: #d3f9d8;
        color: #2f9e44;
    }

    .badge-returned {
        background-color: #f3d9fa;
        color: #862e9c;
    }

    .btn-export {
        background: linear-gradient(to right, #ff90d2, #bd0298);
        color: white;
        font-weight: 500;
        padding: 8px 16px;
        border: none;
        border-radius: 6px;
        transition: background 0.3s ease;
    }

    .btn-export:hover {
        background: linear-gradient(to right, #e078ba, #9a017b);
    }
</style>

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-journal-text me-2"></i> Laporan Peminjaman</h5>
        <a href="{{ route('laporan.peminjaman.pdf') }}" target="_blank" class="btn btn-export">
            <i class="bi bi-file-earmark-pdf me-1"></i> Export PDF
        </a>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered align-middle table-hover text-center">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Peminjam</th>
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th>Tanggal Pinjam</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjamans as $peminjaman)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $peminjaman->nama_peminjam ?? $peminjaman->user->name }}</td>
                        <td>{{ $peminjaman->barang->nama_barang ?? '-' }}</td>
                        <td>{{ $peminjaman->jumlah }}</td>
                        <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->translatedFormat('d F Y') }}</td>
                        <td>
                            @php
                                $badge = match($peminjaman->status) {
                                    'pending' => 'badge-pending',
                                    'approved' => 'badge-approved',
                                    'returned' => 'badge-returned',
                                    default => 'bg-secondary text-white'
                                };
                            @endphp
                            <span class="badge badge-status {{ $badge }}">{{ ucfirst($peminjaman->status) }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Tidak ada data peminjaman.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
