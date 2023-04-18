<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Service extends Model implements HasMedia
{
    protected $fillable = [
        'yc_id',
        'yc_title',
        'yc_comment',
        'yc_price_min',
        'yc_price_max',
        'yc_duration',
        'scope_id',
        'category_id',
        'group_id',
        'flg_active',
        'name',
        'desc_small',
        'desc',
        'proccess',
        'result',
        'service_type_id',
        'yc_category_name'
    ];


    use InteractsWithMedia;
    use HasFactory;

    public function Service_type() {
        return $this->belongsTo(Service_type::class);
    }

    public function Scope() {
        return $this->belongsTo(Scope::class);
    }

    public function Category() {
        return $this->belongsTo(Category::class);
    }

    public function Group() {
        return $this->belongsTo(Group::class);
    }
}
