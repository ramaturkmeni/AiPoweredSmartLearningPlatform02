<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('student_quiz_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')
                  ->constrained('students')
                  ->cascadeOnDelete();
            $table->foreignId('quiz_id')
                  ->constrained('quizzes')
                  ->cascadeOnDelete();
            $table->decimal('score', 5, 2)->nullable();
            $table->enum('status', ['in_progress', 'submitted'])
                  ->default('in_progress');
            $table->timestamp('taken_at')->useCurrent();
        });
    }

    public function down(): void {
        Schema::dropIfExists('student_quiz_attempts');
    }
};
