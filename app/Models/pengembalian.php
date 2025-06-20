<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pengembalian extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'peminjaman_id',
        'jumlah',
        'tanggal_dikembalikan',
        'kondisi_barang',
        'denda', // denda rusak dari admin
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }

    // Hitung denda keterlambatan (otomatis, tidak disimpan ke kolom denda)
    public function getDendaKeterlambatanAttribute()
    {
        if (!$this->peminjaman || !$this->tanggal_dikembalikan) {
            return 0;
        }

        $tanggalJatuhTempo = Carbon::parse($this->peminjaman->tanggal_pengembalian);
        $tanggalDikembalikan = Carbon::parse($this->tanggal_dikembalikan);

        if ($tanggalDikembalikan->gt($tanggalJatuhTempo)) {
            $jumlahHariTerlambat = $tanggalDikembalikan->diffInDays($tanggalJatuhTempo);
            $dendaPerHari = 10000; // atur sesuai kebijakan
            return $jumlahHariTerlambat * $dendaPerHari;
        }
        return 0;
    }

    // Total denda = denda keterlambatan + denda rusak
    public function getTotalDendaAttribute()
    {
        return ($this->denda ?? 0) + $this->denda_keterlambatan;
    }
}
