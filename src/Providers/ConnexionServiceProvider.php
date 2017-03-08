<?php

namespace Bishopm\Connexion\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Form;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use Bishopm\Connexion\Repositories\SettingsRepository;
use Bishopm\Connexion\Models\Setting;

class ConnexionServiceProvider extends ServiceProvider
{

    protected $commands = [
        'Bishopm\Connexion\Console\InstallConnexionCommand',
        'Bishopm\Connexion\Console\SyncToodledoCommand'
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
        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'connexion');
        $this->loadMigrationsFrom(__DIR__.'/../Database/migrations');
        $this->publishes([__DIR__.'/../Assets' => public_path('vendor/bishopm'),], 'public');
        config(['laravel-medialibrary.defaultFilesystem'=>'public']);
        config(['auth.providers.users.model'=>'Bishopm\Connexion\Models\User']);
        $finset=array();
        if (Schema::hasTable('settings')){
            $finset=$settings->makearray();
        }
        view()->share('setting', $finset);
        if (isset($finset['mail_host'])){
            config(['mail.host'=>$finset['mail_host']]);
            config(['mail.port'=>$finset['mail_port']]);
            config(['mail.username'=>$finset['mail_username']]);
            config(['mail.password'=>$finset['mail_password']]);
            //config(['mail.encryption'=>$finset['mail_encryption']]);
        }
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            $event->menu->menu=array();
            $society=Setting::where('setting_key','=','society_name')->first();
            if ($society){
                $society=$society->setting_value . " society";
            } else {
                $society="Society";
            }
            $modules=Setting::where('category','=','modules')->get()->toArray();
            foreach ($modules as $module){
                $mods[$module['setting_key']]=$module['setting_value'];
            }

            $event->menu->add('CHURCH ADMIN');
            $event->menu->add([
                'text' => $society,
                'icon' => 'book',
                'can' => 'read-content',
                'submenu' => [
                    [
                        'text' => 'Households',
                        'url'  => 'admin/households',
                        'icon' => 'child',
                        'can' =>  'read-content'
                    ],
                    [
                        'text' => 'Groups',
                        'url'  => 'admin/groups',
                        'icon' => 'users',
                        'can' =>  'read-content'
                    ],
                    [
                        'text' => 'Messages',
                        'url'  => 'admin/messages/create',
                        'icon' => 'envelope-o',
                        'can' =>  'edit-content'
                    ],
                    [
                        'text' => 'Rosters',
                        'url'  => 'admin/rosters',
                        'icon' => 'calendar',
                        'can' =>  'edit-content'
                    ]
                ]
            ]);
            if ($mods['circuit_preachers']=="yes"){
                $event->menu->add([
                    'text' => 'Circuit',
                    'icon' => 'comments',
                    'can' => 'read-content',
                    'submenu' => [
                        [
                            'text' => 'Preachers',
                            'url'  => 'admin/preachers',
                            'icon' => 'child',
                            'can' =>  'edit-content'
                        ],
                        [
                            'text' => 'Societies',
                            'url'  => 'admin/societies',
                            'icon' => 'envelope-o',
                            'can' =>  'edit-content'
                        ],
                        [
                            'text' => 'Plan',
                            'url'  => 'admin/plan/' . date('Y') . '/1/edit',
                            'icon' => 'calendar',
                            'can' =>  'edit-content'
                        ],
                        [
                            'text' => 'Meetings',
                            'url'  => 'admin/meetings',
                            'icon' => 'group',
                            'can' =>  'edit-content'
                        ],
                        [
                            'text' => 'Special services',
                            'url'  => 'admin/weekdays',
                            'icon' => 'tree',
                            'can' =>  'edit-content'
                        ]
                    ]
                ]);
            }
            if ($mods['todo_module']=="yes"){
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
            }
            if ($mods['worship_module']=="yes"){
                $event->menu->add([
                    'text' => 'Worship',
                    'icon' => 'music',
                    'can' => 'read-content',
                    'url' => 'admin/worship'
                ]);
            }
            if ($mods['website_module']=="yes"){
                $event->menu->add('WEBSITE');
                $event->menu->add([
                    'text' => 'Blog',
                    'url' => 'admin/blogs',
                    'icon' => 'pencil-square-o',
                    'can' =>  'edit-content'
                ],
                [
                    'text' => 'Resources',
                    'url' => 'admin/resources',
                    'icon' => 'book',
                    'can' =>  'edit-content'
                ],            
                [
                    'text' => 'Sermons',
                    'url' => 'admin/series',
                    'icon' => 'microphone',
                    'can' =>  'edit-content'
                ],
                [
                    'text' => 'Site structure',
                    'icon' => 'sitemap',
                    'can' => 'edit-content',
                    'submenu' => [
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
                        ],
                        [
                            'text' => 'Slides',
                            'url' => 'admin/slides',
                            'icon' => 'picture-o',
                            'can' =>  'administer-site'
                        ]
                    ]
                ],
                [
                    'text' => 'View site',
                    'url' => route('homepage'),
                    'icon' => 'globe',
                    'can' =>  'read-content',
                    'target' => '_blank',
                    'active' => []
                ]
            );
            }
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
        Form::component('bsText', 'connexion::components.text', ['name', 'label' => '', 'placeholder' => '', 'value' => null, 'attributes' => []]);
        Form::component('bsPassword', 'connexion::components.password', ['name', 'label' => '', 'placeholder' => '', 'value' => null, 'attributes' => []]);
        Form::component('bsTextarea', 'connexion::components.textarea', ['name', 'label' => '', 'placeholder' => '', 'value' => null, 'attributes' => []]);
        Form::component('bsThumbnail', 'connexion::components.thumbnail', ['source', 'width' => '100', 'label' => '']);
        Form::component('bsImgpreview', 'connexion::components.imgpreview', ['source', 'width' => '200', 'label' => '']);
        Form::component('bsHidden', 'connexion::components.hidden', ['name', 'value' => null]);
        Form::component('bsSelect', 'connexion::components.select', ['name', 'label' => '', 'options' => [], 'value' => null, 'attributes' => []]);
        Form::component('pgHeader', 'connexion::components.pgHeader', ['pgtitle', 'prevtitle', 'prevroute']);
        Form::component('pgButtons', 'connexion::components.pgButtons', ['actionLabel', 'cancelRoute']);
        Form::component('bsFile', 'connexion::components.file', ['name', 'attributes' => []]);
        if (count($finset)){
            config(['adminlte.title' => $finset['site_name']]);
            config(['adminlte.logo' => $finset['site_logo']]);
            config(['adminlte.logo_mini' => $finset['site_logo_mini']]);
        } else {
            config(['adminlte.title' => 'Connexion']);
            config(['adminlte.logo' => '<b>Connexion</b>']);
            config(['adminlte.logo_mini' => '<b>C</b>x']);
        }
        config(['adminlte.dashboard_url' => 'admin']);
        //config(['adminlte.layout' => 'fixed']);
        config(['adminlte.filters' => [
            \JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
            \JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
            \JeroenNoten\LaravelAdminLte\Menu\Filters\SubmenuFilter::class,
            \JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
            \Bishopm\Connexion\Middleware\MyMenuFilter::class]]);
        config(['laravel-google-calendar.client_secret_json' => public_path('vendor/bishopm/client_secret.json')]);
        config(['laravel-google-calendar.calendar_id'=>'umhlalimethodist@gmail.com']);
        view()->composer('connexion::templates.*', \Bishopm\Connexion\Composers\MenuComposer::class);
        view()->composer('connexion::worship.page', \Bishopm\Connexion\Composers\SongComposer::class);
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
        $this->app->register('Cartalyst\Tags\TagsServiceProvider');
        $this->app->register('Plank\Mediable\MediableServiceProvider');
        $this->app->register('Spatie\Menu\Laravel\MenuServiceProvider');
        $this->app->register('Spatie\GoogleCalendar\GoogleCalendarServiceProvider');
        $this->app->register('Actuallymab\LaravelComment\LaravelCommentServiceProvider');
        AliasLoader::getInstance()->alias("GoogleCalendar", 'Spatie\GoogleCalendar\GoogleCalendarFacade');
        AliasLoader::getInstance()->alias("Menu", 'Spatie\Menu\Laravel\MenuFacade');
        AliasLoader::getInstance()->alias("Form",'Collective\Html\FormFacade');
        AliasLoader::getInstance()->alias("HTML",'Collective\Html\HtmlFacade');
        AliasLoader::getInstance()->alias("MediaUploader",'Plank\Mediable\MediaUploaderFacade');
        $this->app['router']->aliasMiddleware('role', 'Bishopm\Connexion\Middleware\RoleMiddleware');
        $this->registerBindings();
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Bishopm\Connexion\Repositories\ActionsRepository',
            function () {
                $repository = new \Bishopm\Connexion\Repositories\ActionsRepository(new \Bishopm\Connexion\Models\Action());
                return $repository;
            }
        );
        $this->app->bind(
            'Bishopm\Connexion\Repositories\BlogsRepository',
            function () {
                $repository = new \Bishopm\Connexion\Repositories\BlogsRepository(new \Bishopm\Connexion\Models\Blog());
                return $repository;
            }
        );
        $this->app->bind(
            'Bishopm\Connexion\Repositories\FoldersRepository',
            function () {
                $repository = new \Bishopm\Connexion\Repositories\FoldersRepository(new \Bishopm\Connexion\Models\Folder());
                return $repository;
            }
        );
        $this->app->bind(
            'Bishopm\Connexion\Repositories\GroupsRepository',
            function () {
                $repository = new \Bishopm\Connexion\Repositories\GroupsRepository(new \Bishopm\Connexion\Models\Group());
                return $repository;
            }
        );
        $this->app->bind(
            'Bishopm\Connexion\Repositories\HouseholdsRepository',
            function () {
                $repository = new \Bishopm\Connexion\Repositories\HouseholdsRepository(new \Bishopm\Connexion\Models\Household());
                return $repository;
            }
        );
        $this->app->bind(
            'Bishopm\Connexion\Repositories\IndividualsRepository',
            function () {
                $repository = new \Bishopm\Connexion\Repositories\IndividualsRepository(new \Bishopm\Connexion\Models\Individual());
                return $repository;
            }
        );
        $this->app->bind(
            'Bishopm\Connexion\Repositories\MeetingsRepository',
            function () {
                $repository = new \Bishopm\Connexion\Repositories\MeetingsRepository(new \Bishopm\Connexion\Models\Meeting());
                return $repository;
            }
        );
        $this->app->bind(
            'Bishopm\Connexion\Repositories\MenusRepository',
            function () {
                $repository = new \Bishopm\Connexion\Repositories\MenusRepository(new \Bishopm\Connexion\Models\Menu());
                return $repository;
            }
        );
        $this->app->bind(
            'Bishopm\Connexion\Repositories\MenuitemsRepository',
            function () {
                $repository = new \Bishopm\Connexion\Repositories\MenuitemsRepository(new \Bishopm\Connexion\Models\Menuitem());
                return $repository;
            }
        );
        $this->app->bind(
            'Bishopm\Connexion\Repositories\PagesRepository',
            function () {
                $repository = new \Bishopm\Connexion\Repositories\PagesRepository(new \Bishopm\Connexion\Models\Page());
                return $repository;
            }
        );
        $this->app->bind(
            'Bishopm\Connexion\Repositories\PastoralsRepository',
            function () {
                $repository = new \Bishopm\Connexion\Repositories\PastoralsRepository(new \Bishopm\Connexion\Models\Pastoral());
                return $repository;
            }
        );
        $this->app->bind(
            'Bishopm\Connexion\Repositories\PermissionsRepository',
            function () {
                $repository = new \Bishopm\Connexion\Repositories\PermissionsRepository(new \Spatie\Permission\Models\Permission());
                return $repository;
            }
        );
        $this->app->bind(
            'Bishopm\Connexion\Repositories\PlansRepository',
            function () {
                $repository = new \Bishopm\Connexion\Repositories\PlansRepository(new \Spatie\Permission\Models\Plan());
                return $repository;
            }
        );
        $this->app->bind(
            'Bishopm\Connexion\Repositories\PreachersRepository',
            function () {
                $repository = new \Bishopm\Connexion\Repositories\PreachersRepository(new \Bishopm\Connexion\Models\Preacher());
                return $repository;
            }
        );        
        $this->app->bind(
            'Bishopm\Connexion\Repositories\ProjectsRepository',
            function () {
                $repository = new \Bishopm\Connexion\Repositories\ProjectsRepository(new \Bishopm\Connexion\Models\Project());
                return $repository;
            }
        );
        $this->app->bind(
            'Bishopm\Connexion\Repositories\RatingsRepository',
            function () {
                $repository = new \Bishopm\Connexion\Repositories\RatingsRepository(new \Bishopm\Connexion\Models\Rating());
                return $repository;
            }
        );        
        $this->app->bind(
            'Bishopm\Connexion\Repositories\ResourcesRepository',
            function () {
                $repository = new \Bishopm\Connexion\Repositories\ResourcesRepository(new \Bishopm\Connexion\Models\Resource());
                return $repository;
            }
        );
        $this->app->bind(
            'Bishopm\Connexion\Repositories\RolesRepository',
            function () {
                $repository = new \Bishopm\Connexion\Repositories\RolesRepository(new \Spatie\Permission\Models\Role());
                return $repository;
            }
        );
        $this->app->bind(
            'Bishopm\Connexion\Repositories\RostersRepository',
            function () {
                $repository = new \Bishopm\Connexion\Repositories\RostersRepository(new \Spatie\Permission\Models\Roster());
                return $repository;
            }
        );
        $this->app->bind(
            'Bishopm\Connexion\Repositories\SeriesRepository',
            function () {
                $repository = new \Bishopm\Connexion\Repositories\SeriesRepository(new \Bishopm\Connexion\Models\Series());
                return $repository;
            }
        );
        $this->app->bind(
            'Bishopm\Connexion\Repositories\SermonsRepository',
            function () {
                $repository = new \Bishopm\Connexion\Repositories\SermonsRepository(new \Bishopm\Connexion\Models\Sermon());
                return $repository;
            }
        );
        $this->app->bind(
            'Bishopm\Connexion\Repositories\ServicesRepository',
            function () {
                $repository = new \Bishopm\Connexion\Repositories\ServicesRepository(new \Bishopm\Connexion\Models\Service());
                return $repository;
            }
        );
        $this->app->bind(
            'Bishopm\Connexion\Repositories\SettingsRepository',
            function () {
                $repository = new \Bishopm\Connexion\Repositories\SettingsRepository(new \Bishopm\Connexion\Models\Setting());
                return $repository;
            }
        );
        $this->app->bind(
            'Bishopm\Connexion\Repositories\SlidesRepository',
            function () {
                $repository = new \Bishopm\Connexion\Repositories\SlidesRepository(new \Bishopm\Connexion\Models\Slide());
                return $repository;
            }
        );
        $this->app->bind(
            'Bishopm\Connexion\Repositories\SocietiesRepository',
            function () {
                $repository = new \Bishopm\Connexion\Repositories\SocietiesRepository(new \Bishopm\Connexion\Models\Society());
                return $repository;
            }
        );        
        $this->app->bind(
            'Bishopm\Connexion\Repositories\SpecialdaysRepository',
            function () {
                $repository = new \Bishopm\Connexion\Repositories\SpecialdaysRepository(new \Bishopm\Connexion\Models\Specialday());
                return $repository;
            }
        );
        $this->app->bind(
            'Bishopm\Connexion\Repositories\UsersRepository',
            function () {
                $repository = new \Bishopm\Connexion\Repositories\UsersRepository(new \Bishopm\Connexion\Models\User());
                return $repository;
            }
        );
        $this->app->bind(
            'Bishopm\Connexion\Repositories\WeekdaysRepository',
            function () {
                $repository = new \Bishopm\Connexion\Repositories\WeekdaysRepository(new \Bishopm\Connexion\Models\Weekday());
                return $repository;
            }
        );
    }
}
