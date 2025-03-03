<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class birth_info extends Model
{
    protected $fillable = [
        'id',
        'gender',
        'birth_date',
        'birth_city',
        'birth_province',
        'birth_place',
        'birth_city_ar',
        'birth_province_ar',
        'birth_place_ar',
    ];
    protected $primaryKey = 'id';
}
