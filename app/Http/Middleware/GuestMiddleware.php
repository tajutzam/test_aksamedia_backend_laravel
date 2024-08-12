<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class GuestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {


        if(auth('sanctum')->check()){
            return response()->json(
                [
                    'status' => 'failed',
                    'message' => 'Only guests can access this resource.'
                ], 403
            );
        }
        return $next($request);
    }
}
