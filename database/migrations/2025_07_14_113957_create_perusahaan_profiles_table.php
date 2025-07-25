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
    Schema::create('perusahaan_profiles', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('tagline')->nullable();
        $table->text('description')->nullable();
        $table->string('website')->nullable();
        $table->string('location')->nullable();
        $table->string('industry')->nullable();
        $table->string('logo')->nullable();
        $table->string('banner')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perusahaan_profiles');
    }
};
