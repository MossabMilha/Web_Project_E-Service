<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoginProcesse extends Controller
{
    public function showLoginForm()
    {
        return view('loginPage');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::checkEmailPassword($request->email, $request->password);

        if ($user) {
            //If The user is found, we will create a session for the user
            Session::put('user_id', $user->id);
            Session::put('user_name', $user->name);
            Session::put('user_role', $user->role);

            //Depending on the role of the user, we will redirect him to the right page
            if ($user->role == 'admin') {
                return redirect()->route('UserManagement.search');
            } elseif ($user->role == 'department_head') {
                return redirect()->route('department-head.teaching-units.index');
            } elseif ($user->role == 'coordinator') {
                return redirect()->route('Coordinator.teachingUnits');
            } elseif($user->role == 'professor') {
                return redirect()->route('home');
            }elseif($user->role == 'vacataire'){
                return redirect()->route('home');
            }
        } else {
            return back()->withErrors(['error' => 'Invalid email or password']);
        }
    }

    public function logout()
    {
        Session::flush(); // Destroy the session
        return redirect()->route('login');
    }
}
