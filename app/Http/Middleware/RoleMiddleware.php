<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Check if user is logged in
        if (!Auth::check()) {
            return redirect('/');
        }
        
        $userRole = Auth::user()->role;
        
        // TEMPORARY DEBUG - Remove after testing
        if ($userRole != $role) {
            // This will show you exactly what's happening
            abort(403, "Debug: Your role is '{$userRole}' but this page requires '{$role}'");
        }
        
        return $next($request);
    }
}