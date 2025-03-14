<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'professor_id',
        'unit_id',
        'status',
    ];

    // Relationship with professor (User)
    public function professor()
    {
        return $this->belongsTo(User::class, 'professor_id');
    }

    // Relationship with teaching unit
    public function teachingUnit()
    {
        return $this->belongsTo(TeachingUnit::class, 'unit_id');
    }
}
