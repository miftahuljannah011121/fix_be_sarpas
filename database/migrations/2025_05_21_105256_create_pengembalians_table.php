<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengembalians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('peminjaman_id')->constrained('peminjamans')->onDelete('cascade');
            $table->integer('jumlah');
            $table->date('tanggal_dikembalikan');
            $table->enum('kondisi_barang', ['baik', 'terlambat', 'rusak', 'hilang']);
            $table->integer('denda')->default(0);
            $table->enum('status', ['pending', 'completed', 'damage', 'returned'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalians');
    }
};
