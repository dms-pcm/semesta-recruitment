<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                $response = response()->json([
                    'status' => [
                        'code' => 401,
                        'message' => 'Your token is invalid. Please, login again.'
                    ]
                ], Response::HTTP_UNAUTHORIZED);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                $response = response()->json([
                    'status' => [
                        'code' => 401,
                        'message' => 'Your token has expired. Please, login again.'
                    ]
                ], Response::HTTP_UNAUTHORIZED);
            } else {
                $response = response()->json([
                    'status' => [
                        'code' => 401,
                        'message' => 'Please, attach a Bearer Token to your request'
                    ]
                ], Response::HTTP_UNAUTHORIZED);
            }

            return $response;
        }
        return $next($request);
    }
}
