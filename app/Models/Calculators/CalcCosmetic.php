<?php

namespace App\Models\Calculators;

use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;
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
        'services' => 'array'
    ];

    use HasFactory;
    use HasJsonRelationships;

    public function Service()
    {
        return $this->belongsToJson(Service::class, 'services');
    }
}
