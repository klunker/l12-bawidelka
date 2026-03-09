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
        Schema::create('google_reviews', function (Blueprint $table) {
            $table->id();
            $table->string('author_name');
            $table->string('author_url')->nullable();
            $table->string('profile_photo_url')->nullable();
            $table->integer('rating');
            $table->text('text')->nullable();
            $table->string('language')->nullable();
            $table->string('original_language')->nullable();
            $table->boolean('translated')->default(false);
            $table->string('relative_time_description')->nullable();
            $table->integer('time'); // Unix timestamp from Google
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Composite unique key to prevent duplicates
            $table->unique(['author_name', 'time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('google_reviews');
    }
};
