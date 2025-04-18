<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'assessment_id',
        'grade_normal',
        'grade_retake',
    ];

    // Relationship with Student
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Relationship with Assessment
    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }
}
