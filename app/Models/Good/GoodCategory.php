<?php

namespace App\Models\Good;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class GoodCategory extends Model implements HasMedia
{
    protected $fillable = [
        'title',
        'position'
    ];

    use InteractsWithMedia;

    use HasFactory;

    public function Good() {
        return $this->hasMany(Good::class);
    }
}
