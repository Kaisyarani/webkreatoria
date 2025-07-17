<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Menggunakan UUID lebih modern
            $table->string('type'); // Tipe notifikasi (mis., 'App\Notifications\NewComment')
            $table->morphs('notifiable'); // Kolom untuk user_id dan user_type
            $table->text('data'); // Kolom untuk menyimpan data notifikasi (dalam format JSON)
            $table->timestamp('read_at')->nullable(); // Kapan notifikasi dibaca (NULL jika belum dibaca)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
