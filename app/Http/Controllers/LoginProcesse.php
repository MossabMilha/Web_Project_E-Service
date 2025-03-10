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
            // Store user session manually
            Session::put('user_id', $user->id);
            Session::put('user_name', $user->name);
            Session::put('user_role', $user->role);

            return redirect()->route('home');
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
