<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseApp extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_name',
        'user_mobile',
        'user_comment',
        'course_id',
        'consult_status_id'
    ];

    public function ConsultStatus() {
        return $this->belongsTo(ConsultStatus::class);
    }

    public function Course() {
        return $this->belongsTo(Course::class);
    }

}
