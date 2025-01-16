<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FreeShipping extends Model
{
    protected $fillable = [
        'min_amount',
        'start_at',
        'end_at',
        'is_active',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'is_active' => 'boolean',
    ];
}
