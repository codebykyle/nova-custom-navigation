<?php

namespace CodeByKyle\NovaCustomNavigation;

use CodeByKyle\NovaCustomNavigation\Console\Commands\CreateNavigation;
use CodeByKyle\NovaCustomNavigation\Console\Commands\SyncNavigation;
use Laravel\Nova\Nova;
use Laravel\Nova\Events\ServingNova;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use CodeByKyle\NovaCustomNavigation\Http\Middleware\Authorize;

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views/overrides', 'nova-test');
        $this->loadViewsFrom(__DIR__.'/../resources/views/application', 'nova-custom-navigation');

        Nova::serving(function (ServingNova $event) {
            CustomNavigation::navigationGroupsIn(app_path('Nova/Navigation'));

            Nova::tools([
                new NovaCustomNavigation()
            ]);
        });

        $this->app->booted(function () {
            $this->routes();
        });

        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateNavigation::class,
            ]);
        }
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova', Authorize::class])
                ->prefix('nova-vendor/nova-custom-navigation')
                ->group(__DIR__.'/../routes/api.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
