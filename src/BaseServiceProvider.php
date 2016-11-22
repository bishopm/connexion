<?php

namespace bishopm\base;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class BaseServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        if (! $this->app->routesAreCached()) {
            require __DIR__.'/Http/routes.php';
        }
        $this->loadViewsFrom(__DIR__.'/resources/views', 'base');
        $this->loadMigrationsFrom(__DIR__.'/migrations');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register('JeroenNoten\LaravelAdminLte\ServiceProvider');
        $this->app->register('Collective\Html\HtmlServiceProvider');
        AliasLoader::getInstance()->alias("Form",'Collective\Html\FormFacade');
        AliasLoader::getInstance()->alias("HTML",'Collective\Html\HtmlFacade');
        $this->app['router']->middleware('authadmin', 'bishopm\base\Middleware\AdminMiddleware');
    }
}
