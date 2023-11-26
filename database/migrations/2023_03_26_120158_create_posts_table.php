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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string ('slug')->unique ();
            $table->text('summary');
            $table->longText ('description')->nullable();
            $table->text ('quote')->nullable();
            $table->string('photo')->nullable();
            $table->string('tags')->nullable();
            $table->unsignedBigInteger ('post_cat_id')->nullable();
            $table->unsignedBigInteger ('post_tag_id')->nullable();
            $table->unsignedBigInteger ('added_by')->nullable();
            $table->enum ('status', ['active', 'inactive'])->default ('active');
            $table->foreign ('post_cat_id')->references ('id')->on ('post_categories')->onDelete ('SET NULL');
            $table->foreign ('post_tag_id')->references ('id')->on ('post_tags')->onDelete ('SET NULL');
            $table->foreign ('added_by')->references ('id')->on ('users')->onDelete ('SET NULL');
            $table->timestamps ();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
