<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentParentInfo extends Model
{
    use HasFactory;

    protected $table = 'parents';

    protected $fillable = [
        'student_id', 'parent_phone', 'father_profession',
        'mother_profession', 'parents_province', 'parents_address'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
