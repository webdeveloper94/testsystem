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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            // Foreign key for 'tests' table
            $table->foreignId('test_id')->constrained('tests')->onDelete('cascade'); // specify 'tests' table explicitly
            $table->text('question_text'); // The actual question
            $table->string('option_a'); // Option A
            $table->string('option_b'); // Option B
            $table->string('option_c'); // Option C
            $table->string('option_d'); // Option D
            // Correct answer (enum to restrict values)
            $table->enum('correct_option', ['a', 'b', 'c', 'd']);
            $table->text('explanation')->nullable(); // Explanation for the correct answer
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
