<?php

namespace bishopm\base\Providers;

use Illuminate\Support\Facades\Blade;
use Form;
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
        $this->publishes([__DIR__.'/../Assets' => public_path('vendor/bishopm'),], 'public');
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
        Form::component('bsText', 'base::components.text', ['name', 'label' => '', 'placeholder' => '', 'value' => null, 'attributes' => []]);
        Form::component('bsTextarea', 'base::components.textarea', ['name', 'label' => '', 'placeholder' => '', 'value' => null, 'attributes' => []]);
        Form::component('bsHidden', 'base::components.hidden', ['name', 'value' => null]);
        Form::component('bsSelect', 'base::components.select', ['name', 'label' => '', 'options' => [], 'value' => null, 'attributes' => []]);
        Form::component('pgHeader', 'base::components.pgHeader', ['pgtitle', 'prevtitle', 'prevroute']);
        Form::component('pgButtons', 'base::components.pgButtons', ['actionLabel', 'cancelRoute']);
        config(['adminlte.title' => 'Umhlali Methodist Church']);
        config(['adminlte.logo' => '<b>Umhlali</b>Methodist']);
        config(['adminlte.logo_mini' => '<b>U</b>MC']);
        config(['adminlte.layout' => 'fixed']);
        config(['auth.providers.users.model'=>'bishopm\base\Models\User']);
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
        $this->app->register('Cviebrock\EloquentSluggable\ServiceProvider');
        $this->app->register('Laratrust\LaratrustServiceProvider');
        AliasLoader::getInstance()->alias("Laratrust",'Laratrust\LaratrustFacade');
        AliasLoader::getInstance()->alias("Form",'Collective\Html\FormFacade');
        AliasLoader::getInstance()->alias("HTML",'Collective\Html\HtmlFacade');
        $this->app['router']->middleware('authadmin', 'bishopm\base\Middleware\AdminMiddleware');
        $this->app['router']->middleware('role','Laratrust\Middleware\LaratrustRole');
        $this->app['router']->middleware('permission','Laratrust\Middleware\LaratrustPermission');
        $this->app['router']->middleware('ability','Laratrust\Middleware\LaratrustAbility');
        $this->registerBindings();
    }

    private function registerBindings()
    {
        $this->app->bind(
            'bishopm\base\Repositories\GroupsRepository',
            function () {
                $repository = new \bishopm\base\Repositories\GroupsRepository(new \bishopm\base\Models\Group());
                return $repository; 
            }
        );
        $this->app->bind(
            'bishopm\base\Repositories\HouseholdsRepository',
            function () {
                $repository = new \bishopm\base\Repositories\HouseholdsRepository(new \bishopm\base\Models\Household());
                return $repository; 
            }
        );
        $this->app->bind(
            'bishopm\base\Repositories\IndividualsRepository',
            function () {
                $repository = new \bishopm\base\Repositories\IndividualsRepository(new \bishopm\base\Models\Individual());
                return $repository; 
            }
        );
        $this->app->bind(
            'bishopm\base\Repositories\PastoralsRepository',
            function () {
                $repository = new \bishopm\base\Repositories\PastoralsRepository(new \bishopm\base\Models\Pastoral());
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
        $this->app->bind(
            'bishopm\base\Repositories\SpecialdaysRepository',
            function () {
                $repository = new \bishopm\base\Repositories\SpecialdaysRepository(new \bishopm\base\Models\Specialday());
                return $repository; 
            }
        );
        $this->app->bind(
            'bishopm\base\Repositories\UsersRepository',
            function () {
                $repository = new \bishopm\base\Repositories\UsersRepository(new \bishopm\base\Models\User());
                return $repository; 
            }
        );
    }
}
