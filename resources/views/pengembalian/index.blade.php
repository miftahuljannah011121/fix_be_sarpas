@extends('layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Daftar Pengembalian</h4>
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
                            <th>Peminjam</th>
                            <th>Barang</th>
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
                                    @if($pengembalian->peminjaman && $pengembalian->peminjaman->user)
                                        {{ $pengembalian->peminjaman->nama_peminjam }}
                                        <span class="d-block text-muted small">{{ $pengembalian->peminjaman->user->name }}</span>
                                    @else
                                        <span class="text-muted">Data tidak tersedia</span>
                                    @endif
                                </td>
                                <td>
                                    @if($pengembalian->peminjaman && $pengembalian->peminjaman->barang)
                                        {{ $pengembalian->peminjaman->barang->nama_barang }}
                                    @else
                                        <span class="text-muted">Data tidak tersedia</span>
                                    @endif
                                </td>
                                <td>{{ $pengembalian->jumlah_dikembalikan }}</td>
                                <td>{{ $pengembalian->tanggal_pengembalian }}</td>
                                <td>
                                    @if($pengembalian->status_pengembalian == 'pending')
                                        <span class="badge bg-warning">Menunggu</span>
                                    @elseif($pengembalian->status_pengembalian == 'completed')
                                        <span class="badge bg-success">Selesai</span>
                                    @elseif($pengembalian->status_pengembalian == 'damaged')
                                        <span class="badge bg-danger">Rusak</span>
                                    @endif
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
                                        <div class="d-flex justify-content-center gap-1">
                                            <form action="{{ route('pengembalian.approve', $pengembalian->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success"
                                                    onclick="return confirm('Yakin ingin menyetujui pengembalian ini?')">
                                                    Setujui
                                                </button>
                                            </form>
                                            <form action="{{ route('pengembalian.reject', $pengembalian->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Yakin ingin menolak pengembalian ini?')">
                                                    Tolak
                                                </button>
                                            </form>
                                        </div>
                                    @endif

                                    @if($pengembalian->status_pengembalian == 'pending')
                                        <a href="{{ route('pengembalian.markDamage.form', $pengembalian->id) }}"
                                            class="btn btn-sm btn-warning">
                                            Tandai Rusak
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-3 text-muted">Belum ada data pengembalian.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection