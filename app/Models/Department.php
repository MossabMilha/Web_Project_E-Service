<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'head_id',
        'email',
        'phone',
        'location',
    ];

    // Relationship with department head (User)
    public function head()
    {
        return $this->belongsTo(User::class, 'head_id');
    }

    // Relationship with teaching units
    public function teachingUnits()
    {
        return $this->hasMany(TeachingUnit::class);
    }
    public function find($id)
    {
        return $this->where('id', $id)->first();
    }

    public function departmentMember(){
        return $this->hasMany(DepartmentMember::class);
    }

    public function specializations()
    {
        return $this->hasMany(Specialization::class);
    }
    public function filieres()
    {
        return $this->hasMany(Filiere::class);
    }
}
