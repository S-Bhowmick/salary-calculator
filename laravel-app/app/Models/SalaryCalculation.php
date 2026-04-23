<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryCalculation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'job_title',
        'experience',
        'location',
        'calculated_salary',
        'is_favorite',
    ];
}