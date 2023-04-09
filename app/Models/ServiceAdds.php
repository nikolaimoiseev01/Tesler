<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceAdds extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_add',
        'to_service'
    ];
}
