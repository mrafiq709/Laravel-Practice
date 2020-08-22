<?php

namespace App\Http\Middleware;

use Closure;

class AuthKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->header('x-api-key');
        if ($token != 'bbfe292a773aa314b527a4fdf23d5ebe') {
            return response()->json(['message' => 'API Key not found'], 401); // 401 => Unathorize
        }

        return $next($request);
    }
}
