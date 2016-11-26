<?php

namespace bishopm\base\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use bishopm\base\Repositories\SettingsRepository;

class BaseServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(Dispatcher $events, SettingsRepository $settings)
    {
        if (! $this->app->routesAreCached()) {
            require __DIR__.'/../Http/routes.php';
        }
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'base');
        $this->loadMigrationsFrom(__DIR__.'/../migrations');
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            $event->menu->menu=array();
            $event->menu->add('CHURCH ADMIN');
            $event->menu->add([
                'text' => 'Members',
                'icon' => 'user',
                'submenu' => [
                    [
                        'text' => 'Households',
                        'url'  => 'admin/households',
                        'icon' => 'user'
                    ],
                    [
                        'text' => 'Groups',
                        'url'  => 'admin/groups',
                        'icon' => 'users'
                    ]
                ]
            ]);
            $event->menu->add('WEBSITE');
            $event->menu->add([
                'text' => 'Blog',
                'url' => 'admin/blog',
                'icon' => 'file'
            ]);
            $event->menu->add('SETTINGS');
            $event->menu->add([
                'text' => 'User profile',
                'url' => 'admin/users/current',
                'icon' => 'user'
            ]);
            $event->menu->add([
                'text' => 'System settings',
                'url' => 'admin/settings',
                'icon' => 'cog'
            ]);
        });
        foreach ($settings->all() as $setting){
            $finset[$setting->setting_key]=$setting->setting_value;
        }
        view()->share('setting', $finset);

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
        $this->registerBindings();
    }

    private function registerBindings()
    {
        $this->app->bind(
            'bishopm\base\Repositories\HouseholdsRepository',
            function () {
                $repository = new \bishopm\base\Repositories\HouseholdsRepository(new \bishopm\base\Models\Household());
                return $repository; 
            }
        );
        $this->app->bind(
            'bishopm\base\Repositories\SettingsRepository',
            function () {
                $repository = new \bishopm\base\Repositories\SettingsRepository(new \bishopm\base\Models\Setting());
                return $repository; 
            }
        );
    }
}
