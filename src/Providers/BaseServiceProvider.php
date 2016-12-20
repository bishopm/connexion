<?php

namespace bishopm\base\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Form, Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use bishopm\base\Repositories\SettingsRepository;

class BaseServiceProvider extends ServiceProvider
{

    protected $commands = [
        'bishopm\base\Console\InstallConnexionCommand'
    ];

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
        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'base');
        $this->loadMigrationsFrom(__DIR__.'/../Database/migrations');
        $this->publishes([__DIR__.'/../Assets' => public_path('vendor/bishopm'),], 'public');
        config(['laravel-medialibrary.defaultFilesystem'=>'public']);
        config(['auth.providers.users.model'=>'bishopm\base\Models\User']);
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            $event->menu->menu=array();
            $event->menu->add('CHURCH ADMIN');
            $event->menu->add([
                'text' => 'Congregation',
                'icon' => 'book',
                'can' => 'read-content',
                'submenu' => [
                    [
                        'text' => 'Members',
                        'url'  => 'admin/households',
                        'icon' => 'child',
                        'can' =>  'read-content'
                    ],
                    [
                        'text' => 'Groups',
                        'url'  => 'admin/groups',
                        'icon' => 'users',
                        'can' =>  'read-content'
                    ]
                ]
            ]);
            $event->menu->add([
                'text' => 'Todo',
                'icon' => 'list-ol',
                'can' => 'read-content',
                'submenu' => [
                    [
                        'text' => 'Tasks',
                        'url'  => 'admin/actions',
                        'icon' => 'check-square-o',
                        'can' =>  'read-content'
                    ],
                    [
                        'text' => 'Folders',
                        'url'  => 'admin/folders',
                        'icon' => 'folder-open-o',
                        'can' =>  'administer-site'
                    ],
                    [
                        'text' => 'Projects',
                        'url'  => 'admin/projects',
                        'icon' => 'tasks',
                        'can' =>  'read-content'
                    ]
                ]
            ]);
            $event->menu->add('WEBSITE');
            $event->menu->add([
                'text' => 'Blog',
                'url' => 'admin/blog',
                'icon' => 'pencil-square-o',
                'can' =>  'read-content'
            ],
            [
                'text' => 'Menus',
                'url'  => 'admin/menus',
                'icon' => 'bars',
                'can' =>  'administer-site'
            ],            
            [
                'text' => 'Pages',
                'url' => 'admin/pages',
                'icon' => 'file',
                'can' =>  'administer-site'
            ]);
            $event->menu->add([
                'header' => 'SETTINGS',
                'can' => 'administer-site'
            ]);
            $event->menu->add([
                'text' => 'User access',
                'icon' => 'user',
                'can' =>  'administer-site',
                'submenu' => [
                    [
                        'text' => 'Permissions',
                        'url'  => 'admin/permissions',
                        'icon' => 'users',
                        'can' =>  'administer-site'
                    ],
                    [
                        'text' => 'Roles',
                        'url'  => 'admin/roles',
                        'icon' => 'user',
                        'can' =>  'administer-site'
                    ],
                    [
                        'text' => 'Users',
                        'url' => 'admin/users',
                        'icon' => 'user',
                        'can' =>  'administer-site'
                    ]
                ]
            ]);           
            $event->menu->add([
                'text' => 'System settings',
                'url' => 'admin/settings',
                'icon' => 'cog',
                'can' =>  'administer-site'
            ]);
        });
        $finset=array();
        if (Schema::hasTable('settings')){
            foreach ($settings->all() as $setting){
                $finset[$setting->setting_key]=$setting->setting_value;
            }
        }
        view()->share('setting', $finset);
        Form::component('bsText', 'base::components.text', ['name', 'label' => '', 'placeholder' => '', 'value' => null, 'attributes' => []]);
        Form::component('bsPassword', 'base::components.password', ['name', 'label' => '', 'placeholder' => '', 'value' => null, 'attributes' => []]);
        Form::component('bsTextarea', 'base::components.textarea', ['name', 'label' => '', 'placeholder' => '', 'value' => null, 'attributes' => []]);
        Form::component('bsThumbnail', 'base::components.thumbnail', ['source', 'width' => '100', 'label' => '']);
        Form::component('bsHidden', 'base::components.hidden', ['name', 'value' => null]);
        Form::component('bsSelect', 'base::components.select', ['name', 'label' => '', 'options' => [], 'value' => null, 'attributes' => []]);
        Form::component('pgHeader', 'base::components.pgHeader', ['pgtitle', 'prevtitle', 'prevroute']);
        Form::component('pgButtons', 'base::components.pgButtons', ['actionLabel', 'cancelRoute']);
        Form::component('bsFile', 'base::components.file', ['name', 'attributes' => []]);
        config(['adminlte.title' => $finset['site_name']]);
        config(['adminlte.dashboard_url' => 'admin']);
        config(['adminlte.logo' => $finset['site_logo']]);
        config(['adminlte.logo_mini' => $finset['site_logo_mini']]);
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
        $this->commands($this->commands);
        $this->app->register('JeroenNoten\LaravelAdminLte\ServiceProvider');
        $this->app->register('Collective\Html\HtmlServiceProvider');
        $this->app->register('Cviebrock\EloquentSluggable\ServiceProvider');
        $this->app->register('Spatie\Permission\PermissionServiceProvider');
        $this->app->register('Spatie\Tags\TagsServiceProvider');
        $this->app->register('Plank\Mediable\MediableServiceProvider');
        $this->app->register('Spatie\Menu\Laravel\MenuServiceProvider');
        AliasLoader::getInstance()->alias("Menu", 'Spatie\Menu\Laravel\MenuFacade');
        AliasLoader::getInstance()->alias("Form",'Collective\Html\FormFacade');
        AliasLoader::getInstance()->alias("HTML",'Collective\Html\HtmlFacade');
        AliasLoader::getInstance()->alias("MediaUploader",'Plank\Mediable\MediaUploaderFacade');
        $this->app['router']->middleware('role', 'bishopm\base\Middleware\RoleMiddleware');
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
            'bishopm\base\Repositories\MenusRepository',
            function () {
                $repository = new \bishopm\base\Repositories\MenusRepository(new \bishopm\base\Models\Menu());
                return $repository;
            }
        );
        $this->app->bind(
            'bishopm\base\Repositories\MenuitemsRepository',
            function () {
                $repository = new \bishopm\base\Repositories\MenuitemsRepository(new \bishopm\base\Models\Menuitem());
                return $repository;
            }
        );
        $this->app->bind(
            'bishopm\base\Repositories\PagesRepository',
            function () {
                $repository = new \bishopm\base\Repositories\PagesRepository(new \bishopm\base\Models\Page());
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
                $repository = new \bishopm\base\Repositories\PermissionsRepository(new \Spatie\Permission\Models\Permission());
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
                $repository = new \bishopm\base\Repositories\RolesRepository(new \Spatie\Permission\Models\Role());
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
