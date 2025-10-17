<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_name',
        'client_email',
        'client_phone',
        'client_company',
        'client_type',
        'service_description',
        'amount',
        'tax_amount',
        'total_amount',
        'currency',
        'status',
        'valid_until',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'tax_amount' => 'decimal:2',
            'total_amount' => 'decimal:2',
            'valid_until' => 'date',
            'metadata' => 'array',
        ];
    }

    public function scopeByStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }

    public function scopeByClientType(Builder $query, string $clientType): Builder
    {
        return $query->where('client_type', $clientType);
    }

    public function scopePotentialClients(Builder $query): Builder
    {
        return $query->where('client_type', 'potential');
    }

    public function scopeClients(Builder $query): Builder
    {
        return $query->where('client_type', 'client');
    }

    public function scopeExpired(Builder $query): Builder
    {
        return $query->where('valid_until', '<', now());
    }

    public function scopeValid(Builder $query): Builder
    {
        return $query->where(function ($q) {
            $q->whereNull('valid_until')
                ->orWhere('valid_until', '>=', now());
        });
    }
}
