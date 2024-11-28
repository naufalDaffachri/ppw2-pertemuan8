<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_create_reviews_table.php
public function up()
{
    Schema::create('reviews', function (Blueprint $table) {
        $table->id();
        $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Reviewer
        $table->text('review');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
