<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Define permissions based on user roles
        Gate::define('manage-products', function ($user) {
            return in_array($user->role, ['admin', 'manager']);
        });

        Gate::define('manage-categories', function ($user) {
            return in_array($user->role, ['admin', 'manager']);
        });

        Gate::define('manage-units', function ($user) {
            return in_array($user->role, ['admin', 'manager']);
        });

        Gate::define('manage-suppliers', function ($user) {
            return in_array($user->role, ['admin', 'manager']);
        });

        Gate::define('manage-customers', function ($user) {
            return in_array($user->role, ['admin', 'manager', 'cashier']);
        });

        Gate::define('manage-sales', function ($user) {
            return in_array($user->role, ['admin', 'manager', 'cashier']);
        });

        Gate::define('manage-purchases', function ($user) {
            return in_array($user->role, ['admin', 'manager']);
        });

        Gate::define('manage-users', function ($user) {
            return $user->role === 'admin';
        });

        Gate::define('manage-settings', function ($user) {
            return $user->role === 'admin';
        });
    }
}






