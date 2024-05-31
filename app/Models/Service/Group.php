<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'scope_id',
        'category_id',
        'name',
        'position',
    ];

    public function Scope() {
        return $this->belongsTo(Scope::class);
    }

    public function Category() {
        return $this->belongsTo(Category::class);
    }

    public function Service() {
        return $this->hasMany(Service::class);
    }


    use HasFactory;
}
