<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\Models\User;
use Firebase\JWT\JWT;

class JwtMiddleware
{
    public function handle($request, Closure $next, $guard = null)
    {
        $token = $request->bearerToken() ? $request->bearerToken() : $request->cookie('token');

        if(!$token) {
            return redirect('auth/login');
        }

        try {
            $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
        }
        catch(Exception $e) {
            return redirect('auth/login');
        }

        $user = User::find($credentials->sub);

        $request->auth = $user;
        
        return $next($request);
    }
}