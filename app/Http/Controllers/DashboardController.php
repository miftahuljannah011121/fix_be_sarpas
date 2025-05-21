<?php

namespace App\Http\Controllers;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik dasar
        $totalBarang = Barang::sum('stok');
        $totalPeminjaman = Peminjaman::whereDate('created_at', Carbon::today())->count();
        $totalPengembalian = Pengembalian::whereDate('created_at', Carbon::today())->count();
        $totalKategori = Kategori::count();

        // Data untuk chart peminjaman per bulan
        $peminjamanPerBulan = Peminjaman::select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $bulanLabels = [];
        $peminjamanData = [];

        // Inisialisasi data untuk 12 bulan
        for ($i = 1; $i <= 12; $i++) {
            $bulanLabels[] = Carbon::create()->month($i)->format('F');
            $peminjamanData[$i] = 0;
        }

        // Isi data dari database
        foreach ($peminjamanPerBulan as $data) {
            $peminjamanData[$data->bulan] = $data->total;
        }

        // Data untuk chart barang per kategori
        $barangPerKategori = Kategori::withCount('barang')
            ->orderBy('barang_count', 'desc')
            ->get();

        $kategoriLabels = $barangPerKategori->pluck('nama')->toArray();
        $kategoriData = $barangPerKategori->pluck('barang_count')->toArray();

        // Data untuk chart status peminjaman
        $statusPeminjaman = Peminjaman::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status')
            ->toArray();

        $statusLabels = ['Pending', 'Approved', 'Rejected', 'Returned'];
        $statusData = [
            $statusPeminjaman['pending'] ?? 0,
            $statusPeminjaman['approved'] ?? 0,
            $statusPeminjaman['rejected'] ?? 0,
            $statusPeminjaman['returned'] ?? 0
        ];

        return view('dashboard', compact(
            'totalBarang',
            'totalPeminjaman',
            'totalPengembalian',
            'totalKategori',
            'bulanLabels',
            'peminjamanData',
            'kategoriLabels',
            'kategoriData',
            'statusLabels',
            'statusData'
        ));
    }
}
