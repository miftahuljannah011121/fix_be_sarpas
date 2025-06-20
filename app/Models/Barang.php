<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $fillable = ['nama_barang', 'kategori_id', 'stok', 'foto'];

    // Pastikan timestamps diaktifkan
    public $timestamps = true;

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }


    

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }

}