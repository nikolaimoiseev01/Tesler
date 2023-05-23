<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $fillable = [
        'tinkoff_order_id',
        'tinkoff_status',
        'price',
        'goods',
        'name',
        'surname',
        'mobile',
        'need_delivery',
        'city',
        'address',
        'index',
        'good_deli_status_id',
        'good_deli_track_number',
        'good_deli_price',
        'promocode',
    ];

    protected $casts = [
        'goods' => 'array',
    ];

    public function Good_deli_status() {
        return $this->belongsTo(Good_deli_status::class);
    }

    use HasFactory;
}
