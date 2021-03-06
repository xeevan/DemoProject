<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        Gate::define('manage-users', function($user){
            return $user->hasRole('admin');
        });

        Gate::define('verify-as-user', function($user){
            return $user->hasRole('user');
        });

        Gate::define('view-edit-others-post', function($user, $image){
            return $user->id === $image->user_id || $user->hasRole('admin');
        });
    }
}
