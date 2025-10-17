<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'type',
        'message',
        'language',
        'metadata',
        'sent_at',
    ];

    protected $casts = [
        'metadata' => 'array',
        'sent_at' => 'datetime',
    ];

    public function session(): BelongsTo
    {
        return $this->belongsTo(ChatSession::class, 'session_id', 'session_id');
    }

    public function scopeUser($query)
    {
        return $query->where('type', 'user');
    }

    public function scopeBot($query)
    {
        return $query->where('type', 'bot');
    }

    public function scopeSystem($query)
    {
        return $query->where('type', 'system');
    }
}
