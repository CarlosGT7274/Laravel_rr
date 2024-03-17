<?php

namespace App\Http\Middleware;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Closure;

class WithAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session('token')) {
            try {
                JWTAuth::setToken(session('token'))->checkOrFail();
                
                $user = JWTAuth::toUser(session('token'));
                
                return $next($request);

            } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
                return redirect()->route('login.form');
            }
        } else {
            return redirect()->route('login.form');
        }
    }
}
