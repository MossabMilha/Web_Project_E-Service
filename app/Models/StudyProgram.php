<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyProgram extends Model
{
    /** @use HasFactory<\Database\Factories\StudyProgramFactory> */
    use HasFactory;

    protected $id = 'id';
    protected $fillable = [
        'department_id',
        'program_name',
        'program_description'
    ];
}
