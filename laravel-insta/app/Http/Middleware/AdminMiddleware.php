<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;

use App\Models\User;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
            // Checks if the user is authenticated and is an admin
            if(Auth::check() && Auth::user()->role_id == User::ADMIN_ROLE_ID){
                return $next($request); // Proceeds to the next request
            }

            return redirect()->route('index'); // Redirects to the index route
            // 1. Validate if the user is logged in and has an admin role
            // 2. Allows passage of the next request if the conditions are met, else redirects to the index route.

            // handle() used to handle an incoming request
        
    }
}
