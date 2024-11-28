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
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Kolom ID
            $table->string('name'); // Nama pengguna
            $table->string('email')->unique(); // Email pengguna yang unik
            $table->timestamp('email_verified_at')->nullable(); // Verifikasi email
            $table->string('password'); // Password pengguna
            $table->rememberToken(); // Token untuk fitur "remember me"
            $table->timestamps(); // Tanggal dibuat dan diperbarui
            $table->enum('role', ['admin', 'internal_reviewer'])->default('internal_reviewer');
            $table->boolean('is_active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};