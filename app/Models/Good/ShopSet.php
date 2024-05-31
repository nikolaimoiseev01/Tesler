<?php

namespace App\Models\Good;

use App\Models\Staff;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ShopSet extends Model implements HasMedia
{
    protected $fillable = [
        'title',
        'staff_id',
        'goods',
    ];

    protected $casts = [
        'goods' => 'array',
    ];

    use InteractsWithMedia;
    use HasFactory;

    public function Staff() {
        return $this->belongsTo(Staff::class);
    }
}
