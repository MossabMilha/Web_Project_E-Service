<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecurityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event',
        'timestamp',
    ];

    // Relationship with user (User)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
