<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class CustomAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorization',
            ], 401);
        }
        if (auth()->check() && auth()->user()->email === 'vathanak@gmail.com') {
            return $next($request);
        }
        return response()->json([
            'status' => false,
            'message' => 'Unauthorized. Only admin can create clients.',
        ], 403);
    }
}
