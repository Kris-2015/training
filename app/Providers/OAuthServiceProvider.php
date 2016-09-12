<?php

namespace App\Providers;

use App\Models\User;
use Dingo\Api\Auth\Auth;
use Dingo\Api\Auth\Provider\OAuth2;
use Illuminate\Support\ServiceProvider;

class OAuthServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app[Auth::class]->extend('oauth', function ($app) {
            $provider = new OAuth2($app['oauth2-server.authorizer']->getChecker());

            $provider->setUserResolver(function ($id) {
                // code to return user by their ID.

                $user = User::find($id);

                return $user;
            });

            $provider->setClientResolver(function ($id) {
                // code to return a client by their ID
            });

            return $provider;
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
