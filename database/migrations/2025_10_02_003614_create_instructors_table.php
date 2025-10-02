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
        Schema::create('instructors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->json('specialization')->nullable();
            $table->json('experience')->nullable();
            $table->json('education')->nullable();
            $table->json('bio')->nullable();
            $table->json('company')->nullable();
            $table->json('twitter_url')->nullable();
            $table->json('linkedin_url')->nullable();
            $table->json('facebook_url')->nullable();
            $table->json('youtube_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instructors');
    }
};
