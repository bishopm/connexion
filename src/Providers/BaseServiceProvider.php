<?php

namespace bishopm\base\Providers;

use Illuminate\Support\Facades\Blade;
use Form, Laratrust, Auth;
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
        config(['auth.providers.users.model'=>'bishopm\base\Models\User']);
        config(['laratrust.role'=>'bishopm\base\Models\Role']);
        config(['laratrust.permission'=>'bishopm\base\Models\Permission']);
        config(['laravel-medialibrary.defaultFilesystem'=>'public']);
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            $event->menu->menu=array();
            $event->menu->add('CHURCH ADMIN');
            $event->menu->add([
                'text' => 'Congregation',
                'icon' => 'book',
                'permission' => 'read-content',
                'submenu' => [
                    [
                        'text' => 'Members',
                        'url'  => 'admin/households',
                        'icon' => 'child',
                        'permission' =>  'read-content'
                    ],
                    [
                        'text' => 'Groups',
                        'url'  => 'admin/groups',
                        'icon' => 'users',
                        'permission' =>  'read-content'
                    ]
                ]
            ]);
            $event->menu->add([
                'text' => 'Todo',
                'icon' => 'list-ol',
                'permission' => 'read-content',
                'submenu' => [
                    [
                        'text' => 'Tasks',
                        'url'  => 'admin/actions',
                        'icon' => 'check-square-o',
                        'permission' =>  'read-content'
                    ],
                    [
                        'text' => 'Folders',
                        'url'  => 'admin/folders',
                        'icon' => 'folder-open-o',
                        'permission' =>  'administer-site'
                    ],
                    [
                        'text' => 'Projects',
                        'url'  => 'admin/projects',
                        'icon' => 'tasks',
                        'permission' =>  'read-content'
                    ]
                ]
            ]);
            $event->menu->add('WEBSITE');
            $event->menu->add([
                'text' => 'Blog',
                'url' => 'admin/blog',
                'icon' => 'file',
                'permission' =>  'read-content'
            ]);
            $event->menu->add([
                'header' => 'SETTINGS',
                'permission' => 'administer-site'
            ]);
            $event->menu->add([
                'text' => 'User access',
                'icon' => 'user',
                'permission' =>  'administer-site',
                'submenu' => [
                    [
                        'text' => 'Permissions',
                        'url'  => 'admin/permissions',
                        'icon' => 'users',
                        'permission' =>  'administer-site'
                    ],
                    [
                        'text' => 'Roles',
                        'url'  => 'admin/roles',
                        'icon' => 'user',
                        'permission' =>  'administer-site'
                    ],
                    [
                        'text' => 'Users',
                        'url' => 'admin/users',
                        'icon' => 'user',
                        'permission' =>  'administer-site'
                    ]
                ]
            ]);
            $event->menu->add([
                'text' => 'System settings',
                'url' => 'admin/settings',
                'icon' => 'cog',
                'permission' =>  'administer-site'
            ]);
        });
        foreach ($settings->all() as $setting){
            $finset[$setting->setting_key]=$setting->setting_value;
        }
        view()->share('setting', $finset);
        Form::component('bsText', 'base::components.text', ['name', 'label' => '', 'placeholder' => '', 'value' => null, 'attributes' => []]);
        Form::component('bsPassword', 'base::components.password', ['name', 'label' => '', 'placeholder' => '', 'value' => null, 'attributes' => []]);
        Form::component('bsTextarea', 'base::components.textarea', ['name', 'label' => '', 'placeholder' => '', 'value' => null, 'attributes' => []]);
        Form::component('bsThumbnail', 'base::components.thumbnail', ['source', 'width' => '100']);
        Form::component('bsHidden', 'base::components.hidden', ['name', 'value' => null]);
        Form::component('bsSelect', 'base::components.select', ['name', 'label' => '', 'options' => [], 'value' => null, 'attributes' => []]);
        Form::component('pgHeader', 'base::components.pgHeader', ['pgtitle', 'prevtitle', 'prevroute']);
        Form::component('pgButtons', 'base::components.pgButtons', ['actionLabel', 'cancelRoute']);
        Form::component('bsFile', 'base::components.file', ['name', 'attributes' => []]);
        config(['adminlte.title' => 'Umhlali Methodist Church']);
        config(['adminlte.logo' => '<b>Umhlali</b>Methodist']);
        config(['adminlte.logo_mini' => '<b>U</b>MC']);
        config(['adminlte.layout' => 'fixed']);
        config(['adminlte.filters' => [
            \JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
            \JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
            \JeroenNoten\LaravelAdminLte\Menu\Filters\SubmenuFilter::class,
            \JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
            \bishopm\base\Middleware\MyMenuFilter::class]]);
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
        $this->app->register('Spatie\Tags\TagsServiceProvider');
        $this->app->register('Plank\Mediable\MediableServiceProvider');
        AliasLoader::getInstance()->alias("Laratrust",'Laratrust\LaratrustFacade');
        AliasLoader::getInstance()->alias("Form",'Collective\Html\FormFacade');
        AliasLoader::getInstance()->alias("HTML",'Collective\Html\HtmlFacade');
        AliasLoader::getInstance()->alias("MediaUploader",'Plank\Mediable\MediaUploaderFacade');
        $this->app['router']->middleware('authadmin', 'bishopm\base\Middleware\AdminMiddleware');
        $this->app['router']->middleware('role','Laratrust\Middleware\LaratrustRole');
        $this->app['router']->middleware('permission','Laratrust\Middleware\LaratrustPermission');
        $this->app['router']->middleware('ability','Laratrust\Middleware\LaratrustAbility');
        $this->registerBindings();
    }

    private function registerBindings()
    {
        $this->app->bind(
            'bishopm\base\Repositories\ActionsRepository',
            function () {
                $repository = new \bishopm\base\Repositories\ActionsRepository(new \bishopm\base\Models\Action());
                return $repository; 
            }
        );
        $this->app->bind(
            'bishopm\base\Repositories\FoldersRepository',
            function () {
                $repository = new \bishopm\base\Repositories\FoldersRepository(new \bishopm\base\Models\Folder());
                return $repository; 
            }
        );
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
            'bishopm\base\Repositories\PermissionsRepository',
            function () {
                $repository = new \bishopm\base\Repositories\PermissionsRepository(new \bishopm\base\Models\Permission());
                return $repository; 
            }
        );
        $this->app->bind(
            'bishopm\base\Repositories\ProjectsRepository',
            function () {
                $repository = new \bishopm\base\Repositories\ProjectsRepository(new \bishopm\base\Models\Project());
                return $repository; 
            }
        );
        $this->app->bind(
            'bishopm\base\Repositories\RolesRepository',
            function () {
                $repository = new \bishopm\base\Repositories\RolesRepository(new \bishopm\base\Models\Role());
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
