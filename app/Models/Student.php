<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $primaryKey = 'id';
    protected $fillable = [
        'contact_info_id',
        'birth_info_id',
        'bac_info_id',
        'promotion_id',
        'first_name',
        'last_name',
        'CNE',
        'CIN',
    ];
}

