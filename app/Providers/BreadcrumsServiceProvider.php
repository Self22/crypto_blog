<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BreadcrumsServiceProvider extends ServiceProvider
{
    protected $defer = true;

    /**
     * Get the classes provided for deferred loading.
     *
     * @return array
     */
    public function provides(): array
    {
        return [BreadcrumbsManager::class];
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Load the routes/breadcrumbs.php file
        $this->registerBreadcrumbs();

    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Register Manager class singleton with the app container
        $this->app->singleton(BreadcrumbsManager::class, config('breadcrumbs.manager-class'));

        // Register Generator class so it can be overridden
        $this->app->bind(BreadcrumbsGenerator::class, config('breadcrumbs.generator-class'));

        // Register 'breadcrumbs::' view namespace
        // $this->loadViewsFrom(__DIR__ . '/../views/', 'breadcrumbs');
    }

    public function registerBreadcrumbs(): void
    {
        // Load the routes/breadcrumbs.php file, or other configured file(s)
        $files = config('breadcrumbs.files');

        if (! $files) {
            return;
        }

        // If it is set to the default value and that file doesn't exist, skip loading it rather than causing an error
        if ($files === base_path('routes/breadcrumbs.php') && ! is_file($files)) {
            return;
        }

        // Support both Breadcrumbs:: and $breadcrumbs-> syntax by making $breadcrumbs variable available
        /** @noinspection PhpUnusedLocalVariableInspection */
        $breadcrumbs = $this->app->make(BreadcrumbsManager::class);

        // Support both a single string filename and an array of filenames (e.g. returned by glob())
        foreach ((array) $files as $file) {
            require $file;
        }
    }
}
