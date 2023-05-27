<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Good extends Model implements HasMedia
{
    protected $fillable = [
        'yc_id',
        'yc_title',
        'yc_price',
        'yc_category',
        'yc_actual_amount',
        'flg_active',
        'scope_id',
        'name',
        'desc_small',
        'desc',
        'usage',
        'specs_detailed',
        'in_shopsets',
        'capacity',
        'capacity_type',
        'good_category_id',
//        'flg_on_road',
//        'flg_gift_set',
//        'flg_discount',
        'skin_type',
        'hair_type',
        'product_type',
        'brand',
        'promo_text'
    ];


    protected $casts = [
        'in_shopsets' => 'array',
        'good_category_id' => 'array',
        'skin_type' => 'array',
        'hair_type' => 'array',

    ];

    use InteractsWithMedia;

    use HasFactory;

    public function Scope() {
        return $this->belongsTo(Scope::class);
    }

    public function GoodCategory() {
        return $this->belongsTo(GoodCategory::class);
    }
}
