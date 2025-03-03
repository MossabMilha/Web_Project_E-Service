<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentBirthInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'gender', 'birth_date', 'birth_city', 'birth_province',
        'birth_place', 'birth_city_ar', 'birth_province_ar', 'birth_place_ar'
    ];

    public function students()
    {
        return $this->hasMany(Student::class, 'birth_info_id');
    }

    public function teachers()
    {
        return $this->hasMany(Teacher::class, 'birth_info_id');
    }
}
