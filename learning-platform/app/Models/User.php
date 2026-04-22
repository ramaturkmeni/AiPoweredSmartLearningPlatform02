<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'username',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token', // تذكرني
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    // ── Relations ──────────────────────────────

    public function teacher(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(teachers::class);
    }

    public function student(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(students::class);
    }

    // ── Helpers ────────────────────────────────

    public function isTeacher(): bool
    {
        return $this->role === 'teacher';
    }

    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    public function getProfile(): teachers|students|null
    {
        return $this->isTeacher() ? $this->teacher : $this->student;
    }
}
