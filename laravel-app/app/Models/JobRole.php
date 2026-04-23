<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobRole extends Model
{
    protected $fillable = [
        'role_name',
        'base_salary',
        'experience_increment',
        'is_active',
    ];
}