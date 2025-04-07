<?php

namespace App\Http\Middleware;

use App\Models\Session;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{

    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors(['error' => 'You must be logged in to access this page']);
        }

        if (!$request->session()->has('user_role') || $request->session()->get('user_role') !== 'admin') {
            return redirect()->route('login')->withErrors(['error' => 'Access denied']);
        }

        return $next($request);
    }
}
