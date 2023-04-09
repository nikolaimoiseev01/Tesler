<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Abonement extends Model implements HasMedia
{
    use HasFactory;

    protected $fillable = [
        'yc_id',
        'yc_title',
        'yc_price',
        'category_id',
        'flg_active',
        'name',
        'desc_small',
        'desc',
        'usage',
        'specs_detailed'
    ];

    use InteractsWithMedia;
}
