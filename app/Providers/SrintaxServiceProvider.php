<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SrintaxServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Spintax::class, function ($app) {
            return new Spintax();
        });
//        require_once app_path() . '/Helpers/Spintax/spintax.php';
    }
}
