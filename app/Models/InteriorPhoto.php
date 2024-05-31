<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;

class InteriorPhoto extends Model implements HasMedia
{
    use \Spatie\MediaLibrary\InteractsWithMedia;

    protected $fillable = [
        'pic',
        'position',
    ];

    use HasFactory;
}
