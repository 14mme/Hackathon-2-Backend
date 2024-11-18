<?php

namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $response->header('Access-Control-Allow-Origin', '*'); // Atur '*' untuk semua domain, ganti sesuai kebutuhan
        $response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
        // return $next($request)
        //     ->header('Access-Control-Allow-Origin', '*') // Adjust as needed
        //     ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        //     ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        if ($request->getMethod() === 'OPTIONS') {
            return response()->json([], 200);
        }

        return $response;
    }
}
