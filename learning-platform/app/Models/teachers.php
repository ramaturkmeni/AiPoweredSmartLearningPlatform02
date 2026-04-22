<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class teachers extends Model
{
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'gender',
        'phone',
        'location',
    ];

    // ── Relations ──────────────────────────────

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // public function courses(): \Illuminate\Database\Eloquent\Relations\HasMany
    // {
    //     return $this->hasMany(courses::class);
    // }

     public function courses()
    {
        // يجب إضافة 'teacher_id' بشكل صريح لكي لا يبحث عن teachers_id
        return $this->hasMany(courses::class, 'teacher_id');

    }
    // ── Helpers ────────────────────────────────

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
