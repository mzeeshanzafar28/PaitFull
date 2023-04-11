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
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->integer('category');
            $table->text('about');
            $table->integer('total_servings');
            $table->text('ingredients');
            $table->integer('preparation_time');
            $table->integer('cooking_time');
            $table->integer('total_time');
            $table->text('method');
            $table->integer('calories')->nullable();
            $table->integer('fats')->nullable();
            $table->integer('carbs')->nullable();
            $table->integer('proteins')->nullable();
            $table->integer('status')->default(0); // 0:Pending 1:Approved 2:Declined
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
