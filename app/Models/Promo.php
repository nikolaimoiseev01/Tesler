<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Promo extends Model implements HasMedia
{
    protected $fillable = [
        'title',
        'desc',
        'link',
        'link_text',
        'type',
        'position'
    ];

    use InteractsWithMedia;
    use HasFactory;
}
