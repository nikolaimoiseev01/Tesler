<?php

namespace App\Models\Calculators;

use App\Models\Service\Service;
use App\Models\Staff;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalcCosmetic extends Model
{
    protected $fillable = [
        'services',
        'step_1',
        'step_2',
        'step_3',
    ];

    protected $casts = [
        'services' => 'json'
    ];

    use HasFactory;
    use \Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

    public function Service()
    {
        return $this->belongsToJson(Service::class, 'services');
    }
}
