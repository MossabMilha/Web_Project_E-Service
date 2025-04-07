<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CoordinatorMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        // Check if user is logged in and is a coordinator
        if (Session::get('user_role') !== 'coordinator') {
            return redirect()->route('login')->withErrors(['error' => 'Access denied']);
        }

        return $next($request);
    }
}

