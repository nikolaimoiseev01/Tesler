<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class interior_photo extends Model
{
    protected $fillable = [
        'pic',
        'position',
    ];

    use HasFactory;
}
