<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class student_quiz_attempts extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'quiz_id',
        'score',
        'status',
        'taken_at',
    ];

    protected $casts = [
        'score'    => 'decimal:2',
        'taken_at' => 'datetime',
    ];

    // ── Relations ──────────────────────────────

    public function student(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(students::class);
    }

    public function quiz(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(quizzes::class);
    }

    public function answers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(student_answers::class, 'attempt_id');
    }

    // ── Helpers ────────────────────────────────

    public function isSubmitted(): bool
    {
        return $this->status === 'submitted';
    }

    public function submit(): void
    {
        $total   = $this->answers()->count();
        $correct = $this->answers()->where('is_correct', true)->count();

        $this->update([
            'status' => 'submitted',
            'score'  => $total > 0 ? round(($correct / $total) * 100, 2) : 0,
        ]);
    }
}
