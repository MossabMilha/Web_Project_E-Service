<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkloadProfile extends Model
{
    protected $fillable = [
        'type',
        'min_hours',
        'max_hours',
    ];
}
