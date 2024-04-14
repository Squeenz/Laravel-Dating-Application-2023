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
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('smoking_status')->nullable();
            $table->string('has_children')->nullable();
            $table->string('wants_children')->nullable();
            $table->string('education_level')->nullable();
            $table->string('occupation')->nullable();
            $table->string('height')->nullable();
            $table->string('body_type')->nullable();
            $table->string('ethnicity')->nullable();
            $table->string('religion')->nullable();
            $table->string('hobbies')->nullable();
            $table->string('drinking_habits')->nullable();
            $table->string('dietary')->nullable();
            $table->string('exercise_frequency')->nullable();
            $table->string('languages_spoken')->nullable();
            $table->string('pets')->nullable();
            $table->string('music_genres')->nullable();
            $table->string('movies_genres')->nullable();
            $table->string('books_genres')->nullable();
            $table->string('travel')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attributes');
    }
};
