<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    /** @use HasFactory<\Database\Factories\ModuleFactory> */
    use HasFactory;

    protected $table = 'modules';

    protected $primaryKey = 'id';

    protected $fillable = [
        'module_name',
        'module_description',
        'study_program_id',
        'duration_hours'
    ];
}
