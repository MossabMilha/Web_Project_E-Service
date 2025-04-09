<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CoordinatorMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors(['error' => 'You must be logged in to access this page']);
        }

        if (Auth::user()->role !== 'coordinator') {
            return redirect()->route('login')->withErrors(['error' => 'Access denied']);
        }

        return $next($request);
    }
}

