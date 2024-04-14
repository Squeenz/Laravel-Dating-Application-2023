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
        Schema::create('preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user')->constrained('users')->onDelete('cascade');
            $table->string('gender_preference')->nullable();
            $table->json('age_range_preference')->nullable();
            $table->string('location_preference')->nullable();
            $table->json('game_preference')->nullable();
            $table->json('movie_preference')->nullable();
            $table->string('relationship_type_preference')->nullable();
            $table->string('height_preference')->nullable();
            $table->json('interest_hobby_preference')->nullable();
            $table->json('language_preference')->nullable();
            $table->string('smoking_drinking_preference')->nullable();
            $table->string('religion_preference')->nullable();
            $table->string('ethnicity_preference')->nullable();
            $table->json('physical_appearance_preference')->nullable();
            $table->string('pets_preference')->nullable();
            $table->string('children_preference')->nullable();
            $table->string('political_views_preference')->nullable();
            $table->json('personality_traits_preference')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preferences');
    }
};
