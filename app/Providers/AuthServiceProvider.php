<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
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
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('termini', function($user) {
            return $user->termini || $user->is_admin;
        });

        Gate::define('usluge', function($user) {
            return $user->usluge || $user->is_admin;
        });

        Gate::define('categories', function($user) {
            return $user->categories || $user->is_admin;
        });

        Gate::define('klijenti', function($user) {
            return $user->klijenti || $user->is_admin;
        });

        Gate::define('fakture', function($user) {
            return $user->fakture || $user->is_admin;
        });

        Gate::define('repeat-fakture', function($user) {
            return $user->fakture || $user->is_admin;
        });

        Gate::define('goods', function($user) {
            return $user->goods || $user->is_admin;
        });

        Gate::define('pacijenti', function($user) {
            return $user->pacijenti || $user->is_admin;
        });

        Gate::define('specijalisti', function($user) {
            return $user->specijalisti || $user->is_admin;
        });

        Gate::define('statistika', function($user) {
            return $user->statistika || $user->is_admin;
        });

        Gate::define('obavjestenja', function($user) {
            return $user->obavjestenja || $user->is_admin;
        });
    }
}
