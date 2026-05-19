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
        // 1. Pastikan tabel kategoris harus dibuat dulu sebelum produks (Laravel otomatis mendeteksinya)
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('cascade');
            $table->string('nama_produk');
            $table->decimal('harga', 10, 2);
            $table->integer('stok')->default(0);
            $table->text('deskripsi')->nullable(); // Kolom deskripsi utama
            $table->string('gambar')->nullable();    // Kolom gambar utama
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};