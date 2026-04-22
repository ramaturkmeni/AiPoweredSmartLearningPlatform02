<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class lectures extends Model
{
    protected $fillable = [
        'course_id',
        'title',
        'content_text',
        'file_url',
        'video_url',
        'img_url',
        'order_index',
    ];

    // ── Relations ──────────────────────────────

    public function course(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(courses::class,'course_id');
    }

    public function quiz(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(quizzes::class, 'lecture_id');
    }

    // ── Helpers ────────────────────────────────

    public function hasQuiz(): bool
    {
        return $this->quiz()->exists();
    }

    public function hasPublishedQuiz(): bool
    {
        return $this->quiz()->where('status', 'published')->exists();
    }
}
