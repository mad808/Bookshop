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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->unsignedBigInteger('brand_id')->index();
            $table->foreign('brand_id')->references('id')->on('brands')->cascadeOnDelete();
            $table->unsignedBigInteger('year_id')->index();
            $table->foreign('year_id')->references('id')->on('years')->cascadeOnDelete();
            $table->unsignedBigInteger('booklang_id')->index();
            $table->foreign('booklang_id')->references('id')->on('booklangs')->cascadeOnDelete();
            $table->string('name')->index();
            $table->string('writertwo');
            $table->text('description')->nullable();
            $table->Double('price')->default(0);
            $table->Double('bookspage')->default(0);
            $table->string('bar_code')->unique();
//            $table->unsignedDouble ('price')->default(0);
            $table->unsignedInteger('viewed')->default(0);
            $table->unsignedInteger('favorited')->default(0);
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
