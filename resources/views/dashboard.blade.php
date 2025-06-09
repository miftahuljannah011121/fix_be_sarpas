@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">📊 Dashboard Admin</h4>
        <div class="text-muted">{{ now()->format('l, d F Y') }}</div>
    </div>

    <!-- Statistik Kartu -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-primary shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Total Barang</h6>
                            <h3>{{ $totalBarang }}</h3>
                        </div>
                        <div class="align-self-center">
                            📦
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-success shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Total Kategori</h6>
                            <h3>{{ $totalKategori }}</h3>
                        </div>
                        <div class="align-self-center">
                            🗂️
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-warning shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Peminjaman Hari Ini</h6>
                            <h3>{{ $totalPeminjaman }}</h3>
                        </div>
                        <div class="align-self-center">
                            📥
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-info shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Pengembalian Hari Ini</h6>
                            <h3>{{ $totalPengembalian }}</h3>
                        </div>
                        <div class="align-self-center">
                            📤
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik -->
    <div class="row mb-3">
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h6 class="mb-0">📅 Peminjaman Barang per Bulan</h6>
                </div>
                <div class="card-body">
                    <canvas id="peminjamanChart" height="160"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h6 class="mb-0">📍 Status Peminjaman</h6>
                </div>
                <div class="card-body">
                    <canvas id="statusChart" height="160"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Peminjaman Terbaru -->
    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center bg-light">
                    <h6 class="mb-0">🕓 Peminjaman Terbaru</h6>
                    <a href="{{ route('peminjaman.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-sm mb-0">
                            <thead class="table-light">
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
                                            @php
                                                $statusBadge = [
                                                    'pending' => ['Menunggu', 'warning'],
                                                    'approved' => ['Disetujui', 'success'],
                                                    'rejected' => ['Ditolak', 'danger'],
                                                    'returned' => ['Dikembalikan', 'info'],
                                                ];
                                                [$label, $color] = $statusBadge[$peminjaman->status];
                                            @endphp
                                            <span class="badge bg-{{ $color }}">{{ $label }}</span>
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

    <!-- Chart Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
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
                    aspectRatio: 2,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { precision: 0 }
                        }
                    }
                }
            });

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
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                boxWidth: 12,
                                font: { size: 11 }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
