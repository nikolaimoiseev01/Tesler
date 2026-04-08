<?php

namespace App\Models;

use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;

class InteriorPhoto extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'pic',
        'position',
    ];

    use HasFactory;
}
