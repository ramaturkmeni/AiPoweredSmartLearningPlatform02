<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentQuizAttempt extends Model
{
    public $timestamps = false;

    protected $table = 'student_quiz_attempts';

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

    public function student(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function quiz(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function answers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(StudentAnswer::class, 'attempt_id');
    }

    public function isSubmitted(): bool
    {
        return $this->status === 'submitted';
    }

    // public function submit(): void
    // {
    //     $total   = $this->answers()->count();
    //     $correct = $this->answers()->where('is_correct', true)->count();

    //     $this->update([
    //         'status' => 'submitted',
    //         'score'  => $total > 0 ? round(($correct / $total) * 100, 2) : 0,
    //     ]);
    // }
    public function submit(): void
{
    $total   = $this->answers()->count();
    $correct = $this->answers()->where('is_correct', true)->count();

    $this->update([
        'status'   => 'submitted',
        'score'    => $total > 0 ? round(($correct / $total) * 100, 2) : 0,
        'taken_at' => now(), // أضف هذا السطر لتسجيل وقت التسليم الآن
    ]);
}

}
