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
}
