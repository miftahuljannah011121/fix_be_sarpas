@extends('layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Daftar Peminjaman</h4>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
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
                                        <span class="d-block text-muted small">Stok tersedia: {{ $peminjaman->barang->stok }}</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $peminjaman->jumlah }}
                                    @if($peminjaman->barang && $peminjaman->status == 'pending' && $peminjaman->jumlah > $peminjaman->barang->stok)
                                        <span class="badge bg-danger">Stok tidak cukup</span>
                                    @endif
                                </td>
                                <td>{{ $peminjaman->tanggal_pinjam }}</td>
                                <td>{{ Str::limit($peminjaman->alasan_meminjam, 50) }}</td>
                                <td>
                                    @if($peminjaman->status == 'pending')
                                        <span class="badge bg-warning">Menunggu</span>
                                    @elseif($peminjaman->status == 'approved')
                                        <span class="badge bg-success">Disetujui</span>
                                    @elseif($peminjaman->status == 'rejected')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @elseif($peminjaman->status == 'returned')
                                        <span class="badge bg-info">Dikembalikan</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($peminjaman->status == 'pending')
                                        <div class="d-flex justify-content-center gap-1">
                                            <form action="{{ route('peminjaman.approve', $peminjaman->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success"
                                                    {{ ($peminjaman->barang && $peminjaman->jumlah > $peminjaman->barang->stok) ? 'disabled' : '' }}
                                                    {{ ($peminjaman->barang && $peminjaman->jumlah > $peminjaman->barang->stok) ? 'title=Stok tidak mencukupi' : '' }}
                                                    onclick="return confirm('Yakin ingin menyetujui peminjaman ini?')">
                                                    Setujui
                                                </button>
                                            </form>
                                            <form action="{{ route('peminjaman.reject', $peminjaman->id) }}" method="POST"
                                                class="d-inline">
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
                                <td colspan="8" class="text-center py-3 text-muted">Belum ada data peminjaman.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection