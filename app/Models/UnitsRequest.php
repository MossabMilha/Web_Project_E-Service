<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitsRequest extends Model
{
    /** @use HasFactory<\Database\Factories\UnitsRequestFactory> */
    use HasFactory;

    protected $table = 'units_request';
    protected $fillable = [
        'professor_id',
        'unit_id',
        'status',
        'semester',
        'academic_year',
        'requested_at',
        'reviewed_at',
        'reviewed_by',
    ];

    public $timestamps = false; // manually managing timestamps

    public function professor()
    {
        return $this->belongsTo(User::class, 'professor_id');
    }

    public function unit()
    {
        return $this->belongsTo(TeachingUnit::class, 'unit_id');
    }
}
