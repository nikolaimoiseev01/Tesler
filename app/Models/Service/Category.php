<?php

namespace App\Models\Service;

use App\Models\Staff;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Category extends Model implements HasMedia
{

    use \Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

    protected $fillable = [
        'scope_id',
        'name',
        'desc',
        'pic',
        'position',
        'block_title',
        'staff_ids'
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

    public function Staff()
    {
        return $this->belongsToJson(Staff::class, 'staff_ids');
    }

//    public function Staff() {
//        return $this->hasMany(Staff::class);
//    }

}
