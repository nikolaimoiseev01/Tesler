<?php

namespace App\Models\Service;

use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;
use App\Models\Promo;
use App\Models\Staff;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Category extends Model implements HasMedia
{

    use HasJsonRelationships;

    protected $fillable = [
        'scope_id',
        'name',
        'desc',
        'pic',
        'position',
        'block_title',
        'staff_ids',
        'promo_id'
    ];

    use HasFactory;
    use InteractsWithMedia;

    protected $casts = [
        'staff_ids' => 'json'
    ];

    public function Scope() {
        return $this->belongsTo(Scope::class);
    }


    public function Group() {
        return $this->hasMany(Group::class);
    }

    public function Service() {
        return $this->hasMany(Service::class);
    }

    public function Promo() {
        return $this->belongsTo(Promo::class);
    }

    public function Staff()
    {
        return $this->belongsToJson(Staff::class, 'staff_ids');
    }

//    public function Staff() {
//        return $this->hasMany(Staff::class);
//    }

}
