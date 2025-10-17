<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'checkin_date',
        'checkout_date',
        'destination_country',
        'destination_city',
        'preferences',
        'adults',
        'children',
        'budget',
        'status',
        'search_results',
    ];

    protected function casts(): array
    {
        return [
            'checkin_date' => 'date',
            'checkout_date' => 'date',
            'preferences' => 'array',
            'search_results' => 'array',
            'budget' => 'decimal:2',
        ];
    }
}
