<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IntegrationField extends Model
{
    use HasFactory;

    protected $fillable = [
        'integration_id',
        'name',
        'label',
        'type',
        'required',
        'options',
        'placeholder',
        'help_text',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'required' => 'boolean',
        'options' => 'array',
        'is_active' => 'boolean',
    ];

    public function integration(): BelongsTo
    {
        return $this->belongsTo(Integration::class);
    }
}
