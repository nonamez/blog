<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\Models;
use App\Policies;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Models\Invoices\Client::class => Policies\Invoices\Client::class,
        Models\Invoices\Invoice::class => Policies\Invoices\Invoice::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureGates();
        $this->registerPolicies();
    }

    private function configureGates(): void
    {
        Gate::before(function($user, $ability) {
            if ($user->is_admin) {
                return TRUE;
            }
        });

        $abilities = config('abilities');

        foreach ($abilities as $abilty) {
            Gate::define($abilty, function($user) use($abilty) {
                return $user->abilities()->where('name', $abilty)->exists();
            });
        }
    }
}
