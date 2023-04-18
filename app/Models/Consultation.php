<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    protected $fillable = [
        'user_name',
        'user_mobile',
        'user_comment',
        'consult_status_id'
    ];

    public function ConsultStatus() {
        return $this->belongsTo(ConsultStatus::class);
    }

    use HasFactory;
}
