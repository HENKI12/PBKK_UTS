<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseLecturer extends Model
{
    use HasFactory;

    protected $table = 'course_lecturers';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id', 'course_id', 'lecturer_id', 'role'];

    // Relasi ke course (menggunakan course_id)
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }

    // Relasi ke lecturer (menggunakan lecturer_id)
    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class, 'lecturer_id', 'lecturer_id');
    }
}
