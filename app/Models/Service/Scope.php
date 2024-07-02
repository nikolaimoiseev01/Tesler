<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Scope extends Model implements HasMedia
{
    protected $fillable = [
        'name',
        'desc',
        'pic_main_page',
        'pic_scope_page',
        'position',
        'flg_active',
        'faqs',
        'advs'
    ];

    protected $casts = [
        'faqs' => 'array',
        'advs' => 'array'
    ];

    use HasFactory;
    use InteractsWithMedia;

    public function Category() {
        return $this->hasMany(Category::class);
    }

    public function Group() {
        return $this->hasMany(Group::class);
    }

    public function Service() {
        return $this->hasMany(Service::class);
    }


}
