<?php

namespace App\Models\Calculators;

use App\Models\Service\Service;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalcHair extends Model
{
    protected $fillable = [
        'service_id',
        'step_1',
        'step_2',
        'step_3',
        'result_price'
    ];

    public function Service() {
        return $this->belongsTo(Service::class);
    }

    use HasFactory;
}
