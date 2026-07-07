<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $table = 'quizzes';

    protected $fillable = [
        'lecture_id',
        'title',
        'is_ai_generated',
        'status',
        'start_time',
        'end_time',
        'duration',
    ];

    protected $casts = [
        'is_ai_generated' => 'boolean',
        'start_time'      => 'datetime',
        'end_time'        => 'datetime',
    ];

    public function lecture(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Lecture::class);
    }

    public function questions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function attempts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(StudentQuizAttempt::class);
    }

    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    public function publish(): bool
    {
        return $this->update(['status' => 'published']);
    }

    public function getQuestionsCountAttribute(): int
    {
        return $this->questions()->count();
    }

    public function getAverageScoreAttribute(): float
    {
        return round(
            $this->attempts()
                 ->where('status', 'submitted')
                 ->avg('score') ?? 0,
            2
        );
    }
}
