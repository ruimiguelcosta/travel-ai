<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Integration extends Model
{
    protected $fillable = [
        'integration_category_id',
        'name',
        'slug',
        'description',
        'base_url',
        'configuration',
        'is_active',
    ];

    protected $casts = [
        'configuration' => 'array',
        'is_active' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(IntegrationCategory::class, 'integration_category_id');
    }
}
