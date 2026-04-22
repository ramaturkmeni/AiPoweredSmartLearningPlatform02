<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class courses extends Model
{
    protected $fillable = [
        'teacher_id',
        'title',
        'description',
    ];

    // ── Relations ──────────────────────────────

    public function teacher(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        // return $this->belongsTo(teachers::class);
         return $this->belongsTo(teachers::class, 'teacher_id');
    }

    public function lectures(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(lectures::class,'course_id' )->orderBy('order_index');
    }

    public function enrollments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(course_enrollments::class);
    }

    public function students(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(students::class, 'course_enrollments')
                    ->withPivot('status', 'enrolled_at')
                    ->wherePivot('status', 'active');
    }

    // ── Helpers ────────────────────────────────

    public function getActiveStudentsCountAttribute(): int
    {
        return $this->enrollments()->where('status', 'active')->count();
    }
}
