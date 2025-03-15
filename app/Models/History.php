<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;
    protected $table = 'history';
    // Disable automatic handling of created_at and updated_at
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'action',
        'timestamp',
    ];

    // Relationship with user (User)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
