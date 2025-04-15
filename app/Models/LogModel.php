<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogModel extends Model
{
    protected $table = 'logs';
    protected $fillable = ['user_id', 'action', 'description'];
    public $timestamps = false;

    public static function track($action, $description = null)
    {
        self::create([
            'user_id' => auth()->user()->id,
            'action' => $action,
            'description' => $description
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
