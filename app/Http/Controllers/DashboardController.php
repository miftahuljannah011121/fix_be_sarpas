<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'totalKategori' => 10,
            'totalBarang' => 150,
            'peminjamanHariIni' => 20,
            'pengembalianHariIni' => 10
        ]);
    }
}
