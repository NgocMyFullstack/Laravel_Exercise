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
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('cart_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->float('price');
            $table->integer('quantity');
            $table-> float('amount');
            $table->foreign('product_id')->references ('id')->on('products')->onDelete('CASCADE');
            $table->foreign('user_id')->references('id')->on ('users')->onDelete('SET NULL');
            $table->foreign('cart_id')->references('id')->on('carts')->onDelete('SET NULL');
            $table->timestamps ();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wishlists');
    }
};
