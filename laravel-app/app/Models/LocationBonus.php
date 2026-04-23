<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocationBonus extends Model
{
    protected $fillable = [
        'location_name',
        'bonus_amount',
    ];
}