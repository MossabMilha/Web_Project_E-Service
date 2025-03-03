<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class student_parent extends Model
{
    protected $fillable = [
        'id',
        'student_id',
        'parent_phone',
        'father_profession',
        'mother_profession',
        'parents_province',
        'parents_adresse',
    ];
    protected $primaryKey = 'id';
}
