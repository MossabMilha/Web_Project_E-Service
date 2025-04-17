<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cne',
        'filiere',
    ];


    public function grades()
    {
        return $this->hasMany(Grade::class, 'student_id');
    }
}
