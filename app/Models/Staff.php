<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Staff extends Model implements HasMedia
{
    protected $fillable = [
        'yc_id',
        'yc_name',
        'yc_avatar',
        'yc_specialization',
        'yc_position',
        'desc_small',
        'desc'
    ];
    /**
     * @var mixed
     */
    use InteractsWithMedia;

    use HasFactory;
}
