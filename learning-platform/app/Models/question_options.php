<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class question_Options extends Model
{
    protected $fillable = [
        'question_id',
        'option_text',
        'is_correct',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    // ── Relations ──────────────────────────────

    public function question(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(questions::class);
    }
}
