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
    ];

    public function add($name, $description, $hours, $type, $credits, $semester){
        return self::create([
            'name' => $name,
            'description' => $description,
            'hours'=> $hours,
            'type' => $type,
            'credits' => $credits,
            'semester' => $semester,
        ]);
    }

    public function updateField($id, $field, $value)
    {
        $unit = self::findOrFail($id);
        $unit->$field = $value;
        $unit->save();
        return $unit;
    }

    // Relationship with department
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // Relationship with filieres
    public function filiere()
    {
        return $this->belongsTo(Filiere::class, 'filiere_id');
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



}
