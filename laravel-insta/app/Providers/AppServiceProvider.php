<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

use Illuminate\Support\Facades\Gate;

use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Paginator::useBootstrap();

        // Define 'admin' gate based on users role
        Gate::define('admin', function($user){
            return $user->role_id == User::ADMIN_ROLE_ID;
            // 1. Sete up 'admin' gate allowing access based on the user's role
            // 2. The closure checks if the user's role ID matches the admin role ID
        });

        // Gates are simply closure that determine if the user is authorized to perform a given action.
        // We use a gate to create a gate that will show certain items to admins only
    }
}
