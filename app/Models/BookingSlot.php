<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingSlot extends Model
{
    protected $fillable = [
        'booking_date',
        'booking_time',
        'quota',
        'is_available',
    ];

    protected function casts(): array
    {
        return [
            'booking_date' => 'date',
            'booking_time' => 'datetime:H:i:s',
            'quota' => 'integer',
            'is_available' => 'boolean',
        ];
    }
}
