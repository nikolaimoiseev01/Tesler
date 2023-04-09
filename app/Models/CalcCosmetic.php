<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalcCosmetic extends Model
{
    protected $fillable = [
        'services',
        'step_1',
        'step_2',
        'step_3',
    ];

    protected $casts = [
        'services' => 'array'
    ];

    use HasFactory;
}
