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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->json('name');
            $table->json('description');
            $table->json('difficulty_degree');
            $table->json('objectives');
            $table->decimal('price', 10, 2);
            $table->string('availability')->nullable();
            $table->enum('accessibility', ['active', 'inactive'])->default('active');
            $table->enum('progression', ['chapter', 'lecture'])->default('chapter');
            $table->string('tags')->nullable();
            $table->decimal('duration');
            $table->string('cover');
            $table->string('thumbnail');
            $table->string('video');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
