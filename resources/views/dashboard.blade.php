@extends('layouts.app')

@section('content')
    <h2>Dashboard Admin Sisfo SMK Taruna Bhakti</h2>

    <div class="row mt-4">
        @php
            $cards = [
                ['label' => 'Total Kategori', 'value' => $totalKategori],
                ['label' => 'Total Barang', 'value' => $totalBarang],
                ['label' => 'Peminjaman Hari Ini', 'value' => $peminjamanHariIni],
                ['label' => 'Pengembalian Hari Ini', 'value' => $pengembalianHariIni]
            ];
        @endphp

        @foreach($cards as $card)
            <div class="col-md-3 mb-3">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <h5 class="card-title">{{ $card['label'] }}</h5>
                        <h3>{{ $card['value'] }}</h3>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Peminjaman Barang per Bulan</h5>
                    <div class="bg-light" style="height:200px;"></div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Barang Berdasarkan Kategori</h5>
                    <div class="bg-light" style="height:200px;"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
