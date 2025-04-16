<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromCollection, WithHeadings
{
    protected $users;

    // Constructor accepts a collection of users
    public function __construct($users)
    {
        $this->users = $users;
    }

    public function collection()
    {
        // Return the collection of users for export
        return collect($this->users)->map(function ($user) {
            return [
                'id'             => $user->id,
                'name'           => $user->name,
                'email'          => $user->email,
                'phone'          => $user->phone,
                'role'           => $user->role,
                'specialization' => $user->specialization ?? 'N/A',  // Default 'N/A' if null
                'created_at'     => $user->created_at->format('Y-m-d H:i:s'),  // Format date
                'updated_at'     => $user->updated_at->format('Y-m-d H:i:s'),  // Format date
            ];
        });
    }

    // Define the headers for the Excel file
    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Phone',
            'Role',
            'Specialization',
            'Created At',
            'Updated At',
        ];
    }
}
