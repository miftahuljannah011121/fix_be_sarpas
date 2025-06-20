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
        background-color: #fff0c1;
        color: #7d5700;
    }

    .badge-completed {
        background-color: #c0f5d3;
        color: #05633b;
    }

    .badge-damage {
        background-color: #f6c1e5;
        color: #85004c;
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
        <h5 class="mb-0"><i class="bi bi-clipboard-check me-2"></i> Laporan Pengembalian</h5>
        <a href="{{ route('laporan.pengembalian.pdf') }}" target="_blank" class="btn btn-export">
            <i class="bi bi-file-earmark-pdf me-1"></i> Export PDF
        </a>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered align-middle table-hover text-center">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Peminjam</th>
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                        <th>Denda</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengembalians as $pengembalian)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $pengembalian->peminjaman->nama_peminjam ?? $pengembalian->peminjaman->user->name }}</td>
                        <td>{{ $pengembalian->peminjaman->barang->nama_barang ?? '-' }}</td>
                        <td>{{ $pengembalian->jumlah }}</td>
                        <td>{{ \Carbon\Carbon::parse($pengembalian->tanggal_dikembalikan)->translatedFormat('d F Y') }}</td>
                        <td>
                            @php
                                $badge = match($pengembalian->status) {
                                    'pending' => 'badge-pending',
                                    'completed' => 'badge-completed',
                                    'damage' => 'badge-damage',
                                    default => 'bg-secondary text-white'
                                };
                            @endphp
                            <span class="badge badge-status {{ $badge }}">{{ ucfirst($pengembalian->status) }}</span>
                        </td>
                        <td>Rp{{ number_format($pengembalian->total_denda, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Tidak ada data pengembalian.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
