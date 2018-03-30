<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App;
use Blade;

class WidgetServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive(
            'widget', function ($name) {
            return "<?php echo app('widget')->show($name); ?>";
        }
        );

        $this->loadViewsFrom(resource_path('views/widgets'), 'widgets');

    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        App::singleton(
            'widget', function () {
            return new \App\Widgets\Widget();
        }
        );
    }

}
