<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        // If not logged in, Auth middleware usually handles this, 
        // but we add a safety check here.
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // If the user's role does NOT match the required route role
        if (Auth::user()->role !== $role) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}