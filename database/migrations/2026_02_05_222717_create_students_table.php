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
        Schema::create('students', function (Blueprint $table) {
            $table->id();

            // Link to the users table
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Level: A or B
            $table->enum('level', ['A', 'B']);

            // Category: A, B, or C
            $table->enum('category', ['A', 'B', 'C']);

            // Group: A, B, or C
            $table->enum('group', ['A', 'B', 'C']);

            // Unique Index Number for the student
            $table->string('index_number')->unique();

            // Number of attempts left (default 3)
            $table->integer('attempts_left')->default(3);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
