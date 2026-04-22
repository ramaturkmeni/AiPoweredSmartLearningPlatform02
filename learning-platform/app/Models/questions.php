<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class questions extends Model
{
    protected $fillable = [
        'quiz_id',
        'question_text',
    ];

    // ── Relations ──────────────────────────────

    public function quiz(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(quizzes::class);
    }

    public function options(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(question_options::class);
    }

    public function correctOption(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(question_options::class)
                    ->where('is_correct', true);
    }

    public function studentAnswers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(student_answers::class);
    }
}
