<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Admin
{

    public function handle(Request $request, Closure $next)
    {
        if (Session::get('user_role') !== 'admin') {
            return redirect()->route('login')->withErrors(['error' => 'Access denied']);
        }

        return $next($request);
    }
}
