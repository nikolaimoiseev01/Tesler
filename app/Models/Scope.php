<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scope extends Model
{
    protected $fillable = [
        'name',
        'desc',
        'pic_main_page',
        'pic_scope_page',
        'position',
        'flg_active'
    ];


    use HasFactory;

    public function Category() {
        return $this->hasMany(Category::class);
    }

    public function Service() {
        return $this->hasMany(Service::class);
    }

    public function Group() {
        return $this->hasMany(Group::class);
    }


}
