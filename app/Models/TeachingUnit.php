<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeachingUnit extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'hours',
        'type',
        'credits',
        'semester',
        'filiere_id',
    ];

    public function add($name, $description, $hours, $type, $credits, $semester,$filiere_id){
        return self::create([
            'name' => $name,
            'description' => $description,
            'hours'=> $hours,
            'type' => $type,
            'credits' => $credits,
            'semester' => $semester,
            'filiere_id' => $filiere_id,
        ]);
    }

    public function updateField($id, $field, $value)
    {
        $unit = self::findOrFail($id);
        $unit->$field = $value;
        $unit->save();
        return $unit;
    }
    public function assignmentStatus()
    {
        $latest = $this->assignments()
            ->whereIn('status', ['approved', 'pending'])
            ->latest()
            ->first();

        return match ($latest?->status) {
            'approved' => 'assigned',
            'pending' => 'pending',
            default => 'unassigned',
        };
    }
    public function assignedVacataire()
    {
        $latestAssignment = $this->assignments()
            ->whereNotNull('professor_id')
            ->latest()
            ->first();

        $professor = $latestAssignment?->professor;

        return $professor && $professor->role === 'vacataire';
    }
    public function assignedProfessorId()
    {
        $latestAssignment = $this->assignments()
            ->whereNotNull('professor_id')
            ->latest()
            ->first();

        // Return the professor's ID regardless of their role
        return $latestAssignment?->professor_id;
    }

    // Relationship with department
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // Relationship with filieres
    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }

    // Relationship with assignments
    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'unit_id');
    }

    // Relationship with grades
    public function grades()
    {
        return $this->hasMany(Grade::class, 'unit_id');
    }

    public function unitsRequest()
    {
        return $this->hasMany(UnitsRequest::class , 'unit_id');
    }



}
