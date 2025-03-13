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
    public function search(Request $request){
        $searchTerm = $request->input('search');
        $searchOption = $request->input('option', 'id'); // Default is 'id'
        if ($searchTerm) {
            if ($searchOption === 'id') {
                $users = User::whereRaw("CAST(id AS CHAR) LIKE ?", ['%' . $searchTerm . '%'])->get();
            } else {
                $users = User::where($searchOption, 'like', '%' . $searchTerm . '%')->get();
            }
        } else {
            $users = User::all();
        }
        return view('AdminUserManagement', compact('users'));
    }
}
