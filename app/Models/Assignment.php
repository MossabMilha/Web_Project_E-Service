<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\TeachingUnit;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'professor_id',
        'unit_id',
        'status'
    ];

    // Table name (optional, useful if it's different)
    protected $table = 'assignments';

    // Status constants for better maintainability
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

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
