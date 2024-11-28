<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_create_review_tag_table.php
public function up()
{
    Schema::create('review_tag', function (Blueprint $table) {
        $table->id();
        $table->foreignId('review_id')->constrained('reviews')->onDelete('cascade');
        $table->foreignId('tag_id')->constrained('tags')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_tag');
    }
};
