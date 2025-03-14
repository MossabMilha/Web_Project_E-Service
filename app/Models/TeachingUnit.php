<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeachingUnit extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'department_id',
        'hours',
        'credits',
        'semester',
    ];

    // Relationship with department
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // Relationship with assignments
    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'unit_id');
    }

    // Relationship with grades
    public function grades()
    {
        return $this->hasMany(Grade::class, 'unit_id');
    }
}
