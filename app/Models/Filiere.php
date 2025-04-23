<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    protected $fillable = [
        'name',
        'description',
        'coordinator_id',
        'department_id',
    ];

    public function TeachingUnits()
    {
        return $this->hasMany(TeachingUnit::class);
    }

    public function department(){
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function students()
    {
        return $this->hasMany(Student::class, 'filiere');
    }
}
