<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Integration extends Model
{
    use HasFactory;

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

    public function fields(): HasMany
    {
        return $this->hasMany(IntegrationField::class)->orderBy('sort_order');
    }
}
