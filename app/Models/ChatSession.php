<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChatSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'language',
        'template_data',
        'is_complete',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'template_data' => 'array',
        'is_complete' => 'boolean',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class, 'session_id', 'session_id');
    }

    public function scopeComplete($query)
    {
        return $query->where('is_complete', true);
    }

    public function scopeIncomplete($query)
    {
        return $query->where('is_complete', false);
    }
}
