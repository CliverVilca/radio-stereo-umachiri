<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminApiMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Ensure the request expects JSON
        $request->headers->set('Accept', 'application/json');
        
        // Add CORS headers for admin API
        $response = $next($request);
        
        if (method_exists($response, 'header')) {
            $response->header('Access-Control-Allow-Origin', '*');
            $response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
            $response->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With, X-CSRF-TOKEN');
        }
        
        return $response;
    }
}