<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class TeachingStaffController extends Controller
{
    public function ShowAssignments($id){
        $user = User::findOrFail($id);
        return view('TeachingStaffAssignment', compact('user') );
    }
}
