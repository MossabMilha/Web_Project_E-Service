<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['department_name', 'department_description'];

    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }

    public function studyPrograms()
    {
        return $this->hasMany(StudyProgram::class);
    }
}
