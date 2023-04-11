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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('restaraunt_category_id');
            $table->bigInteger('regular_price');
            $table->integer('on_discount');
            $table->bigInteger('discounted_price')->nullable();
            $table->json('images');
            $table->integer('min_persons');
            $table->integer('max_persons');
            $table->integer('food_type_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
