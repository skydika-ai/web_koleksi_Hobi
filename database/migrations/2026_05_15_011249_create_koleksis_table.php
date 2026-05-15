<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('koleksis', function (Blueprint $table) {
            
            $table->id();
            // ↑ membuat kolom "id" otomatis angka 1,2,3,...
            
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');
            // ↑ kolom user_id, terhubung ke tabel users
            // kalau user dihapus, koleksinya ikut terhapus otomatis
            
            $table->string('nama');
            // ↑ nama koleksi, contoh: "Elden Ring"
            
            $table->enum('kategori', ['game', 'buku', 'film']);
            // ↑ hanya boleh diisi salah satu: game, buku, atau film
            
            $table->integer('rating')->default(1);
            // ↑ nilai 1 sampai 5, default awal = 1
            
            $table->enum('status', ['dimiliki', 'wishlist']);
            // ↑ apakah sudah dimiliki atau masih wishlist
            
            $table->text('catatan')->nullable();
            // ↑ catatan tambahan, boleh dikosongkan (nullable)
            
            $table->string('gambar')->nullable();
            // ↑ path foto sampul, boleh dikosongkan
            
            $table->timestamps();
            // ↑ otomatis buat kolom created_at dan updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('koleksis');
        // ↑ kalau migration dibatalkan, tabel ini dihapus
    }
};