@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Dashboard Admin</h2>
        <div class="text-muted">{{ now()->format('l, d F Y') }}</div>
    </div>

    <!-- Statistik Kartu -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-title text-muted">Total Barang</h6>
                    <h3>{{ $totalBarang }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-title text-muted">Total Kategori</h6>
                    <h3>{{ $totalKategori }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-title text-muted">Peminjaman Hari Ini</h6>
                    <h3>{{ $totalPeminjaman }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-title text-muted">Pengembalian Hari Ini</h6>
                    <h3>{{ $totalPengembalian }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik -->
    <div class="row mb-3">
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-header py-2">
                    <h6 class="mb-0">Peminjaman Barang per Bulan</h6>
                </div>
                <div class="card-body py-2">
                    <canvas id="peminjamanChart" height="160"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-header py-2">
                    <h6 class="mb-0">Status Peminjaman</h6>
                </div>
                <div class="card-body py-2">
                    <canvas id="statusChart" height="160"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-header py-2 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Peminjaman Terbaru</h6>
                    <a href="{{ route('peminjaman.index') }}" class="btn btn-sm btn-primary py-0 px-2">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>Peminjam</th>
                                    <th>Barang</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse(App\Models\Peminjaman::with(['barang'])->latest()->take(3)->get() as $peminjaman)
                                    <tr>
                                        <td>{{ $peminjaman->nama_peminjam }}</td>
                                        <td>{{ $peminjaman->barang->nama_barang ?? 'Barang tidak tersedia' }}</td>
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
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-2">Belum ada data peminjaman</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Chart Peminjaman per Bulan
            new Chart(document.getElementById('peminjamanChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: @json($bulanLabels),
                    datasets: [{
                        label: 'Jumlah Peminjaman',
                        data: @json(array_values($peminjamanData)),
                        backgroundColor: '#0d6efd',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    aspectRatio: 3,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { precision: 0 }
                        }
                    }
                }
            });

            // Chart Status Peminjaman
            new Chart(document.getElementById('statusChart').getContext('2d'), {
                type: 'pie',
                data: {
                    labels: @json($statusLabels),
                    datasets: [{
                        data: @json($statusData),
                        backgroundColor: ['#ffc107', '#198754', '#dc3545', '#0dcaf0']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    aspectRatio: 3,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                boxWidth: 12,
                                font: {
                                    size: 11
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection