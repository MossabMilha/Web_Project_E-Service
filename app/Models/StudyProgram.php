<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyProgram extends Model
{
    use HasFactory;

    protected $fillable = ['department_id', 'program_name', 'program_description'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function promotions()
    {
        return $this->hasMany(Promotion::class);
    }

    public function modules()
    {
        return $this->hasMany(Module::class);
    }
}
