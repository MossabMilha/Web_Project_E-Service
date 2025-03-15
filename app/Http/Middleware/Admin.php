<?php

        namespace App\Http\Middleware;

        use Closure;
        use Illuminate\Http\Request;
        use Symfony\Component\HttpFoundation\Response;
        use Illuminate\Support\Facades\Auth;

        class Admin
        {

            public function handle(Request $request, Closure $next, $role)
            {
                if (auth()->check() && auth()->user()->role->role_name === "admin") {
                    return $next($request);
                }
                abort(403, 'Unauthorized');
            }
        }
