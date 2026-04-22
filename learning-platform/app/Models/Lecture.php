<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
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

    public function course(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function quiz(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Quiz::class, 'lecture_id');
    }

    public function hasQuiz(): bool
    {
        return $this->quiz()->exists();
    }

    public function hasPublishedQuiz(): bool
    {
        return $this->quiz()->where('status', 'published')->exists();
    }
}