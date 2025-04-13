<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class LoginProcesse extends Controller
{
    public function showLoginForm()
    {
        return view('loginPage');
    }



    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            // Retrieve the authenticated user
            $user = Auth::user();

            // Store user role in the session (optional, since you can use Auth::user()->role directly)
            Session::put('user_role', $user->role);
            return redirect()->route('home');
            // Redirect based on role
//            if ($user->role == 'admin') {
//                return redirect()->route('UserManagement.search');
//            } elseif ($user->role == 'department_head') {
//                return redirect()->route('department-head.teaching-units.index');
//            } elseif ($user->role == 'coordinator') {
//                return redirect()->route('Coordinator.teachingUnits');
//            } elseif (in_array($user->role, ['professor', 'vacataire'])) {
//                return redirect()->route('home');
//            }
        }

        return back()->withErrors(['error' => 'Invalid email or password']);
    }


    public function logout()
    {
        Session::flush(); // Destroy the session
        return redirect()->route('login');
    }
}
