<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ShopSet extends Model implements HasMedia
{
    protected $fillable = [
        'title',
        'staff_id',
    ];

    use InteractsWithMedia;
    use HasFactory;

    public function Staff() {
        return $this->belongsTo(Staff::class);
    }
}
