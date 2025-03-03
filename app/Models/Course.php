<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['course_name', 'course_description', 'module_id', 'total_hours'];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
