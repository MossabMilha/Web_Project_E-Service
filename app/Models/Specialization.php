<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    use HasFactory;


    protected $table = 'specializations';

    // Define the fillable properties
    protected $fillable = [
        'name',
        'department_id',
    ];


    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
