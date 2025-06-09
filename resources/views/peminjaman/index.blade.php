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

        .alert-success {
            background-color: rgb(255, 182, 232);
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

        .badge-info-custom {
            background-color: rgb(229, 182, 255);
            color: #5a0050;
        }
    </style>

    <div class="card shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Daftar Peminjaman</h4>
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
                            <th>Nama Peminjam</th>
                            <th>Barang</th>
                            <th>Jumlah</th>
                            <th>Tanggal Pinjam</th>
                            <th>Alasan</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($peminjamans as $peminjaman)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $peminjaman->nama_peminjam }}</td>
                                <td>
                                    {{ $peminjaman->barang->nama_barang ?? 'Barang tidak ditemukan' }}
                                    @if($peminjaman->barang)
                                       
                                    @endif
                                </td>
                        
                                <td>
                                    {{ $peminjaman->jumlah }}
                                    @if($peminjaman->barang && $peminjaman->status == 'pending' && $peminjaman->jumlah > $peminjaman->barang->stok)
                                        <div><span class="badge bg-danger">Stok tidak cukup</span></div>
                                    @endif
                                </td>
                                <td>{{ $peminjaman->tanggal_pinjam }}</td>
                                <td>{{ Str::limit($peminjaman->alasan_meminjam, 50) }}</td>
                                <td>
                                    @php
                                        $status = $peminjaman->status;
                                        $badgeClass = match($status) {
                                            'pending' => 'badge-warning-custom',
                                            'approved' => 'badge-pink',
                                            'rejected' => 'bg-danger',
                                            'returned' => 'badge-info-custom',
                                            default => 'bg-secondary',
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">
                                        {{ ucfirst($status) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($peminjaman->status == 'pending')
                                        <div class="d-flex justify-content-center gap-1">
                                            <form action="{{ route('peminjaman.approve', $peminjaman->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success"
                                                    {{ ($peminjaman->barang && $peminjaman->jumlah > $peminjaman->barang->stok) ? 'disabled title=Stok tidak mencukupi' : '' }}
                                                    onclick="return confirm('Yakin ingin menyetujui peminjaman ini?')">
                                                    Setujui
                                                </button>
                                            </form>
                                            <form action="{{ route('peminjaman.reject', $peminjaman->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Yakin ingin menolak peminjaman ini?')">
                                                    Tolak
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-3 text-muted">Belum ada data peminjaman.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
