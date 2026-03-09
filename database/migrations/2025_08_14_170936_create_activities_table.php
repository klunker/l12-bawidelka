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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('image');
            $table->decimal('price', 8, 2);
            $table->decimal('weekendPrice', 8, 2);
            $table->integer('duration');
            $table->integer('order');
            $table->integer('ageFrom');
            $table->integer('ageTo');
            $table->integer('maxChildren');
            $table->json('features');
            $table->string('badge')->nullable();
            $table->string('color')->nullable();
            $table->boolean('isActive')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
