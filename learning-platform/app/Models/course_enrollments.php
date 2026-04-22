<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class course_enrollments extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'course_id',
        'status',
        'enrolled_at',
    ];

    protected $casts = [
        'enrolled_at' => 'datetime',
    ];

    // ── Relations ──────────────────────────────

    public function student(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(students::class);
    }

    public function course(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(courses::class);
    }

    // ── Helpers ────────────────────────────────

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
