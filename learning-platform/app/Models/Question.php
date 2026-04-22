<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'quiz_id',
        'question_text',
    ];

    public function quiz(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function options(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(QuestionOption::class);
    }

    public function correctOption(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(QuestionOption::class)
                    ->where('is_correct', true);
    }

    public function studentAnswers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(StudentAnswer::class);
    }
}