<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'gender',
        'phone',
        'location',
        'major',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function enrollments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CourseEnrollment::class);
    }

    public function courses(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_enrollments')
                    ->withPivot('status', 'enrolled_at')
                    ->wherePivot('status', 'active');
    }

    public function quizAttempts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(StudentQuizAttempt::class);
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function isEnrolledIn(int $courseId): bool
    {
        return $this->enrollments()
                    ->where('course_id', $courseId)
                    ->where('status', 'active')
                    ->exists();
    }
}