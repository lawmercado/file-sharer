<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Firebase\JWT\JWT;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['auth']->viaRequest('api', function ($request) {
            $token = $request->bearerToken() ? $request->bearerToken() : $request->cookie('token');

            if(!$token) {
                return null;
            }

            try {
                $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);

                $user = User::find($credentials->sub);

                return $user;
            }
            catch(Exception $e) {
                return null;
            }
        });
    }
}
