<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentAnswer extends Model
{
    protected $table = 'student_answers';

    protected $fillable = [
        'attempt_id',
        'question_id',
        'selected_option_id',
        'is_correct',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    public function attempt(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(StudentQuizAttempt::class, 'attempt_id');
    }

    public function question(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function selectedOption(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(QuestionOption::class, 'selected_option_id');
    }

    public static function createAndCheck(
        int $attemptId,
        int $questionId,
        int $selectedOptionId
    ): self {
        $isCorrect = QuestionOption::where('id', $selectedOptionId)
                                   ->where('is_correct', true)
                                   ->exists();
        return self::create([
            'attempt_id'         => $attemptId,
            'question_id'        => $questionId,
            'selected_option_id' => $selectedOptionId,
            'is_correct'         => $isCorrect,
        ]);
    }
}