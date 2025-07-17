<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Menambahkan kolom 'description' setelah kolom 'category'
            // 'text' lebih cocok untuk deskripsi panjang daripada 'string'
            // 'nullable' berarti kolom ini boleh kosong
            $table->text('description')->nullable()->after('category');
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Logika untuk membatalkan migrasi (menghapus kolom)
            $table->dropColumn('description');
        });
    }
};
