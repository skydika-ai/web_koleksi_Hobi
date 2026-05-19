<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['user', 'admin'])
                  ->default('user')
                  ->after('email');
            // ↑ kolom role ditambahkan setelah kolom email
            // default 'user' → semua user lama otomatis jadi role 'user'
            // enum → hanya boleh diisi 'user' atau 'admin'
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
            // ↑ kalau migration di-rollback, kolom role dihapus
        });
    }
};