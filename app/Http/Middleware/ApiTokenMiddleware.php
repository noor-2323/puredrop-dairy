<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiTokenMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('X-API-Token');
        $expectedToken = config('api.token');

        if (empty($expectedToken) || !is_string($token) || !hash_equals($expectedToken, $token)) {
            return response()->json([
                'message' => 'Unauthorized. Invalid or missing API token.',
            ], 401);
        }

        return $next($request);
    }
}
