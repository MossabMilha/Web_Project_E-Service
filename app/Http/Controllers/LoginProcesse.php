<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LogModel;
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
            $user = Auth::user();
            Session::put('user_role', $user->role);

            LogModel::track('login_success', "{$user->role} {$user->name} (ID: {$user->id}) logged in");
            return redirect()->route('home');
        }

        return back()->withErrors(['error' => 'Invalid email or password']);
    }


    public function logout()
    {
        Auth::logout();
        Session::flush(); // Destroy the session
        return redirect()->route('login');
    }
}
