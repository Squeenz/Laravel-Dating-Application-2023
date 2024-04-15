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
            $table->string('smoking_status');
            $table->string('has_children');
            $table->string('wants_children');
            $table->string('education_level');
            $table->string('occupation');
            $table->string('height');
            $table->string('body_type');
            $table->string('ethnicity');
            $table->string('religion');
            $table->string('hobbies');
            $table->string('drinking_habits');
            $table->string('dietary');
            $table->string('exercise_frequency');
            $table->string('languages_spoken');
            $table->string('pets');
            $table->string('music_genres');
            $table->string('movies_genres');
            $table->string('books_genres');
            $table->string('travel');
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
