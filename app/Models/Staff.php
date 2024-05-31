<?php

namespace App\Models;

use App\Models\Service\Category;
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
        'desc',
        'flg_active',
        'collegues',
        'selected_shopset',
        'selected_abon',
        'selected_sert',
        'experience'
    ];
    /**
     * @var mixed
     */
    use InteractsWithMedia;

    protected $casts = [
        'collegues' => 'array'
    ];

    use HasFactory;

    use \Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

    public function Category()
    {
        return $this->hasManyJson(Category::class, 'staff_ids');
    }
}
