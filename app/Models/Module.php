<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = ['module_name', 'module_description', 'study_program_id', 'duration_hours'];

    public function studyProgram()
    {
        return $this->belongsTo(StudyProgram::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
