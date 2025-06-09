<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $table = 'schedule';

    protected $fillable = [
        'filiere_id',
        'module_id',
        'enseignant_id',
        'jour',
        'time_slot',
        'salle',
        'semestre',
    ];

    // Relationship with Filiere
    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }

    // Relationship with TeachingUnit (module)
    public function teachingUnit()
    {
        return $this->belongsTo(TeachingUnit::class, 'module_id');
    }

    // Relationship with User (enseignant)
    public function enseignant()
    {
        return $this->belongsTo(User::class, 'enseignant_id');
    }
}
