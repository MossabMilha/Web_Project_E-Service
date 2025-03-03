<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name', 'last_name', 'birth_info_id', 'contact_info_id',
        'department_id', 'hire_date', 'specialization', 'contract_type'
    ];

    public function birthInfo()
    {
        return $this->belongsTo(BirthInfo::class);
    }

    public function contactInfo()
    {
        return $this->belongsTo(Contact::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
