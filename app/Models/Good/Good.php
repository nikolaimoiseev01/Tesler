<?php

namespace App\Models\Good;

use App\Models\Service\Category;
use App\Models\Service\Scope;
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
        'category_id',
        'category_id',
        'name',
        'desc_small',
        'desc',
        'usage',
        'specs_detailed',
        'in_shopsets',
        'capacity',
        'capacity_type',
        'good_category_id',
        'skin_type',
        'hair_type',
        'good_type',
        'brand',
        'promo_text',
        'discount',
        'flg_big_block'
    ];


    protected $casts = [
        'in_shopsets' => 'array',
        'good_category_id' => 'array',
        'skin_type' => 'array',
        'hair_type' => 'array',
        'specs_detailed' => 'array'
    ];

    use InteractsWithMedia;

    use HasFactory;

    public function Scope() {
        return $this->belongsTo(Scope::class);
    }

    public function Category() {
        return $this->belongsTo(Category::class);
    }

    public function GoodCategory() {
        return $this->belongsTo(GoodCategory::class);
    }

    public function GoodType() {
        return $this->belongsTo(GoodType::class);
    }
}
