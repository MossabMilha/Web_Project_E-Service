<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class contact extends Model
{
    protected $fillable = [
        'id',
        'phone',
        'email',
        'institutional_email',
    ];
    protected $primaryKey = 'id';
}
