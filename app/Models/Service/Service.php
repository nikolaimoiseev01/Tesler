<?php

namespace App\Models\Service;

use App\Models\Calculators\CalcCosmetic;
use App\Models\Service_type;
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
        'yc_category_name',
        'service_adds'
    ];


    protected $casts = [
        'service_adds' => 'array'
    ];

    use InteractsWithMedia;
    use HasFactory;
    use \Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

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

    public function CalcCosmetic()
    {
        return $this->hasManyJson(CalcCosmetic::class, 'services');
    }

    public function Service()
    {
        return $this->belongsToJson(Service::class, 'service_adds');
    }

}
