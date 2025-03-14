<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workload extends Model
{
    use HasFactory;

    protected $fillable = [
        'professor_id',
        'total_hours',
        'minimum_required_hours',
    ];

    // Relationship with professor (User)
    public function professor()
    {
        return $this->belongsTo(User::class, 'professor_id');
    }
}
