<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentParent extends Model
{
    use HasFactory;

    protected $table = 'parents';
    protected $primaryKey = 'id';
    protected $fillable = [
        'student_id',
        'parent_phone',
        'father_profession',
        'mother_profession',
        'parents_province',
        'parents_address',
    ];

    // Define relationship with Student model
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }
}
