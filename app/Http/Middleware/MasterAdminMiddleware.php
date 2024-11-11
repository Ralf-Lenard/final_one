<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MasterAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the authenticated user is a master admin
        if (Auth::check() && (Auth::user()->usertype === 'master')) {
            return $next($request);
        }

        // If not an admin, redirect or abort
        return redirect('/home'); // Change to your desired route
    }
}
