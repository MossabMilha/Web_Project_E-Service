<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cne',
        'filiere',
        'grade_id',
    ];

    // A student belongs to a grade
    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    // A student belongs to a filiere
    public function filiere()
    {
        return $this->belongsTo(Filiere::class, 'filiere');
    }
}
