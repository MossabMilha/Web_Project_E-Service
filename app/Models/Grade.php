<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'unit_id',
        'professor_id',
        'grade_normal',
        'grade_retake',
    ];

    // ✅ Updated relationship: now points to Student model
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    // Relationship with teaching unit
    public function teachingUnit()
    {
        return $this->belongsTo(TeachingUnit::class, 'unit_id');
    }

    // Relationship with professor (still a User)
    public function professor()
    {
        return $this->belongsTo(User::class, 'professor_id');
    }
}
