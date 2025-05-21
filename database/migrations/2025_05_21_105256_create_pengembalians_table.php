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
            $table->foreignId('peminjaman_id')->constrained('peminjamans')->onDelete('cascade');
            $table->date('tanggal_pengembalian');
            $table->integer('jumlah_dikembalikan');
            $table->enum('status_pengembalian', ['pending', 'completed', 'damaged'])->default('pending');
            $table->text('keterangan')->nullable();
            $table->decimal('denda', 8, 2)->default(0); // jika ada denda
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
