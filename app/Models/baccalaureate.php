<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class baccalaureate extends Model
{
    protected $fillable = [
        'id',
        'bac_year',
        'bac_type',
        'bac_mention',
        'bac_origin',
        'academy',
        'hight_school',
        'hight_school_type',
    ];
    protected $primaryKey = 'id';
}
