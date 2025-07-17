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
    Schema::create('kreator_profiles', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('title')->nullable();
        $table->text('about')->nullable();
        $table->string('photo')->nullable();
        $table->string('banner')->nullable();
        $table->json('skills')->nullable();
        $table->json('social_links')->nullable();
        $table->json('experience')->nullable();
        $table->json('education')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kreator_profiles');
    }
};
