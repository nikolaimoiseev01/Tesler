<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Category extends Model implements HasMedia
{
    protected $fillable = [
        'scope_id',
        'name',
        'desc',
        'pic',
        'position',
        'block_title',
        'staff'
    ];

    use HasFactory;
    use InteractsWithMedia;

    protected $casts = [
        'staff' => 'array'
    ];

    public function Group() {
        return $this->hasMany(Group::class);
    }

    public function Scope() {
        return $this->belongsTo(Scope::class);
    }
}
