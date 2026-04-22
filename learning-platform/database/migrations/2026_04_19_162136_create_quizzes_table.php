<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lecture_id')
                  ->unique()
                  ->constrained('lectures')
                  ->cascadeOnDelete();
            $table->string('title');
            $table->boolean('is_ai_generated')->default(true);
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->unsignedInteger('duration')->nullable()
                  ->comment('المدة بالدقائق');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('quizzes');
    }
};
