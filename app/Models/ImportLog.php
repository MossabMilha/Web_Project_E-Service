<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_name',
        'status',
        'imported_by',
    ];

    // Relationship with user (Imported by)
    public function importedBy()
    {
        return $this->belongsTo(User::class, 'imported_by');
    }
}
