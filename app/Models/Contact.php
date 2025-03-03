<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $primaryKey = 'id';
    protected $fillable = [
        'phone',
        'email',
        'institutional_email',
    ];

}
