<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();
        
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $userRole = strtoupper($user->role->name);
        $allowedRoles = array_map('strtoupper', array_map('trim', $roles));

        if (!$user || !in_array($userRole, $allowedRoles)) {
            return response()->json([
                'message' => 'Forbidden',
                'your_role' => $userRole,
                'allowed' => $allowedRoles
            ], 403);
        }

        return $next($request);
    }
}
