<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class student_answers extends Model
{
    protected $fillable = [
        'attempt_id',
        'question_id',
        'selected_option_id',
        'is_correct',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    // ── Relations ──────────────────────────────

    public function attempt(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(student_quiz_attempts::class, 'attempt_id');
    }

    public function question(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(questions::class);
    }

    public function selectedOption(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(question_Options::class, 'selected_option_id');
    }

    // ── Helpers ────────────────────────────────

    public static function createAndCheck(
        int $attemptId,
        int $questionId,
        int $selectedOptionId
    ): self {
        $isCorrect = question_Options::where('id', $selectedOptionId)
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
