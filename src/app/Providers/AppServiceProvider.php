<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
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
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Illuminate\Support\Facades\Schema::defaultStringLength(191);

        \Illuminate\Database\Eloquent\Relations\Relation::morphMap([
            'user' => 'App\Models\Users\User',
            'post-translated' => 'App\Models\Blog\Posts\Translated',
        ]);
    }
}
