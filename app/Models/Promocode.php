<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promocode extends Model
{
    protected $fillable = [
        'title',
        'discount',
    ];

    use HasFactory;
}
