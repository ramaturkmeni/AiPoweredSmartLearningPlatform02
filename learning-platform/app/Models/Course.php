<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';

    protected $fillable = [
        'teacher_id',
        'title',
        'description',
    ];

    public function teacher(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function lectures(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Lecture::class, 'course_id')->orderBy('order_index');
    }

    public function enrollments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CourseEnrollment::class);
    }

    public function students(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'course_enrollments')
                    ->withPivot('status', 'enrolled_at')
                    ->wherePivot('status', 'active');
    }

    public function getActiveStudentsCountAttribute(): int
    {
        return $this->enrollments()->where('status', 'active')->count();
    }
}