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
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id();
            // Diarahkan ke tabel users
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
            $table->date('borrow_date')->nullable();
            $table->date('return_deadline')->nullable();
            $table->date('returned_at')->nullable();
            $table->integer('fine')->default(0); // Sudah diperbaiki dari (.) menjadi (->)
            $table->enum('status', ['Booking', 'Borrowed', 'Returned'])->default('Booking');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
};
