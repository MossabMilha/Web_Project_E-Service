<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class  AdminController extends Controller
{
    public function UserManagement(){
        $users = User::all();
        return view('AdminUserManagement',compact('users'));
    }
    public function UserInformation($id){
        $user = User::findOrFail($id);
        return view('AdminUserInfo', compact('user'));
    }
    public function AddUser(){
        return view('AdminAddUser');
    }
    public function search(Request $request) {
        $searchTerm = $request->input('search');
        $searchOption = $request->input('option', 'id');

        // Map frontend search options to database columns
        $columnMap = [
            'id' => 'id',
            'full name' => 'name',
            'email' => 'email',
            'role' => 'role',
            'specialization' => 'specialization',
        ];

        $searchOption = $columnMap[$searchOption] ?? 'id';

        $query = User::query();

        if ($searchTerm) {
            if ($searchOption === 'id') {
                $query->whereRaw("CAST(id AS CHAR) LIKE ?", ['%' . $searchTerm . '%']);
            } else {
                $query->where($searchOption, 'like', '%' . $searchTerm . '%');
            }
        }

        $users = $query->paginate(10)->appends(request()->query());;

        return view('AdminUserManagement', compact('users'));
    }
}
