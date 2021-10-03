<?php

namespace App\Providers;

use App\Guards\ClientGuard;
use Illuminate\Auth\RequestGuard;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerGuard();
    }

    /**
     * Register the Authenticator.
     *
     * @return void
     */
    protected function registerGuard()
    {
        Auth::extend('client-guard', function (Application $app) {

            /** @var Request $request */
            $request = $app->get('request');
            return new RequestGuard(function (Request $request) {
                $guard = new ClientGuard($request);

                return $guard->user();
            }, $request);
        });
    }
}
