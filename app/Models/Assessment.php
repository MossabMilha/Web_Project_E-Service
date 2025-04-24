<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use HasFactory;
    protected $table = 'assessments';

    protected $fillable = [
        'name',
        'description',
        'filiere',
        'professor_id',
        'semester',
        'teaching_unit_id', // New field
    ];

    // Relationship with Filiere
    public function filiere(){
        return $this->belongsTo(Filiere::class, 'filiere'); // Specify the correct foreign key
    }

    // Relationship with Professor (User)
    public function professor()
    {
        return $this->belongsTo(User::class, 'professor_id');
    }

    // Relationship with Teaching Unit
    public function teachingUnit()
    {
        return $this->belongsTo(TeachingUnit::class, 'teaching_unit_id');
    }

    // Relationship with Grades
    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function hasGrades(): bool
    {
        return (bool) $this->grades()
            ->where(function($query) {
                $query->whereNotNull('grade_normal')
                    ->orWhereNotNull('grade_retake');
            })
            ->exists();
    }

    public function hasNormalGrades(): bool
    {
        return (bool) $this->grades()
            ->whereNotNull('grade_normal')
            ->exists();
    }

    public function hasRetakeGrades(): bool
    {
        return (bool) $this->grades()
            ->whereNotNull('grade_retake')
            ->exists();
    }
}
