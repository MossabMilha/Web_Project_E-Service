<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_info_id', 'birth_info_id', 'bac_info_id',
        'promotion_id', 'first_name', 'last_name', 'CNE', 'CIN'
    ];

    public function contactInfo()
    {
        return $this->belongsTo(StudentContact::class, 'contact_info_id');
    }

    public function birthInfo()
    {
        return $this->belongsTo(StudentBirthInfo::class, 'birth_info_id');
    }

    public function bacInfo()
    {
        return $this->belongsTo(StudentBaccalaureate::class, 'bac_info_id');
    }

    public function promotion()
    {
        return $this->belongsTo(StudentPromotion::class);
    }

    public function parents()
    {
        return $this->hasOne(StudentParentInfo::class);
    }
}
