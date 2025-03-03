<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentBaccalaureate extends Model
{
    use HasFactory;

    protected $fillable = [
        'bac_year', 'bac_type', 'bac_mention',
        'bac_origin', 'academy', 'high_school', 'high_school_type'
    ];

    public function students()
    {
        return $this->hasMany(Student::class, 'bac_info_id');
    }
}
