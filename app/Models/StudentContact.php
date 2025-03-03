<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentContact extends Model
{
    use HasFactory;

    protected $fillable = ['phone', 'email', 'institutional_email'];

    public function students()
    {
        return $this->hasMany(Student::class, 'contact_info_id');
    }

    public function teachers()
    {
        return $this->hasMany(Teacher::class, 'contact_info_id');
    }
}
