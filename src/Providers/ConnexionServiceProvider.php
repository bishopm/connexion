<?php

namespace Bishopm\Connexion\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Form;
use Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use Bishopm\Connexion\Repositories\SettingsRepository;
use Bishopm\Connexion\Models\Setting;
use Illuminate\Support\Facades\Gate;
use Monolog\Handler\SlackWebhookHandler;
use Monolog\Logger;

class ConnexionServiceProvider extends ServiceProvider
{
    private $settings;

    protected $commands = [
        'Bishopm\Connexion\Console\InstallConnexionCommand',
        'Bishopm\Connexion\Console\BirthdayEmail',
        'Bishopm\Connexion\Console\MonthlySupplierEmail',
        'Bishopm\Connexion\Console\MonthlyBookshopEmail',
        'Bishopm\Connexion\Console\PlannedGivingReportEmail',
    ];

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(Dispatcher $events, SettingsRepository $settings)
    {
        $this->settings=$settings;
        Schema::defaultStringLength(255);
        if (! $this->app->routesAreCached()) {
            require __DIR__.'/../Http/api.routes.php';
            require __DIR__.'/../Http/web.routes.php';
        }
        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'connexion');
        $this->publishes([
        __DIR__.'/../Resources/views/errors' => base_path('resources/views/errors'),
        __DIR__.'/../Resources/views/blocks/templates' => resource_path('views/vendor/bishopm/blocks'),
        __DIR__.'/../Resources/views/templates' => resource_path('views/vendor/bishopm/pages'),
        ]);
        $this->loadMigrationsFrom(__DIR__.'/../Database/migrations');
        $this->publishes([__DIR__.'/../Assets' => public_path('vendor/bishopm'),], 'public');
        $this->publishes([__DIR__.'/../Assets/themes' => base_path('resources/views/vendor/mail/html/themes'),], 'public');
        config(['laravel-medialibrary.defaultFilesystem'=>'public']);
        config(['auth.providers.users.model'=>'Bishopm\Connexion\Models\User']);
        config(['queue.default'=>'database']);
        $finset=array();
        if (Schema::hasTable('settings')) {
            $this->initialiseSettings();
            $allmods=array('bookshop_module'=>['module'=>'module','description'=>'Manage a small bookshop','setting_value'=>'no'],
                'core_module'=>['module'=>'module','description'=>'Church membership data - individuals, households and groups, together with email and sms facilities and reporting','setting_value'=>'yes'],
                'hr_module'=>['module'=>'module','description'=>'Human resources module','setting_value'=>'no'],
                'mcsa_module'=>['module'=>'module','description'=>'Circuit preachers module','setting_value'=>'no'],
                'todo_module'=>['module'=>'module','description'=>'Task and project management module','setting_value'=>'yes'],
                'website_module'=>['module'=>'module','description'=>'Backend module to create a website, including blog, slides, group resources, sermon audio','setting_value'=>'yes'],
                'worship_module'=>['module'=>'module','description'=>'Stores liturgy and songs (with guitar chords), creates service sets and tracks song / liturgy usage','setting_value'=>'yes']
            );
            foreach ($allmods as $key=>$thismod) {
                $sett=Setting::where('setting_key', $key)->first();
                if (!$sett) {
                    $ss=Setting::create(['setting_key'=>$key,'setting_value'=>$thismod['setting_value'],'description'=>$thismod['description'],'module'=>'module']);
                }
            }
            $finset=$settings->makearray();
            view()->share('setting', $finset);
            if ($settings->getkey('mail_host')<>"Invalid") {
                config(['mail.host'=>$settings->getkey('mail_host')]);
                config(['mail.port'=>$settings->getkey('mail_port')]);
                config(['mail.username'=>$settings->getkey('mail_username')]);
                config(['mail.password'=>$settings->getkey('mail_password')]);
                //config(['mail.encryption'=>$settings->getkey('mail_encryption')]);
            }
            config(['broadcasting.pusher.driver'=>'pusher']);
            config(['broadcasting.pusher.key'=>$settings->getkey('pusher_app_key')]);
            config(['broadcasting.pusher.secret'=>$settings->getkey('pusher_app_secret')]);
            config(['broadcasting.pusher.app_id'=>$settings->getkey('pusher_app_id')]);
            config(['broadcasting.pusher.options.cluster'=>$settings->getkey('pusher_cluster')]);
            config(['broadcasting.pusher.options.encrypted'=>'true']);
            if (($settings->getkey('site_name'))<>"Invalid") {
                config(['app.name'=>$settings->getkey('site_name')]);
            }
            config(['mail.from.address'=>$settings->getkey('church_email')]);
            config(['mail.from.name'=>$settings->getkey('site_name')]);
            config(['user-verification.email.view'=>'connexion::emails.newuser']);
            config(['user-verification.email.type'=>'markdown']);
            config(['app.name'=>$settings->getkey('site_name')]);
            $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
                $event->menu->menu=array();
                $modules=Setting::where('module', '=', 'module')->get()->toArray();
                foreach ($modules as $module) {
                    $mods[$module['setting_key']]=$module['setting_value'];
                }
                $event->menu->add('CHURCH ADMIN');
                $event->menu->add([
                    'text' => 'Members',
                    'icon' => 'book',
                    'can' => 'edit-backend',
                    'submenu' => [
                        [
                            'text' => 'Households',
                            'url'  => 'admin/households',
                            'icon' => 'child',
                            'can' =>  'edit-backend'
                        ],
                        [
                            'text' => 'Groups',
                            'url'  => 'admin/groups',
                            'icon' => 'users',
                            'can' =>  'edit-backend'
                        ],
                        [
                            'text' => 'Messages',
                            'url'  => 'admin/messages/create',
                            'icon' => 'envelope-o',
                            'can' =>  'edit-backend'
                        ],
                        [
                            'text' => 'Events',
                            'url'  => 'admin/events',
                            'icon' => 'calendar-check-o',
                            'can' =>  'edit-backend'
                        ],
                        [
                            'text' => 'Rosters',
                            'url'  => 'admin/rosters',
                            'icon' => 'calendar',
                            'can' =>  'edit-backend'
                        ],
                        [
                            'text' => 'Statistics',
                            'url'  => 'admin/statistics',
                            'icon' => 'line-chart',
                            'can' =>  'edit-backend',
                            'active' => []
                        ],
                        [
                            'text' => 'Giving',
                            'url'  => 'admin/payments',
                            'icon' => 'gift',
                            'can' =>  'admin-giving'
                        ]
                    ]
                ]);
                if ($mods['mcsa_module']=="yes") {
                    $event->menu->add([
                        'text' => 'Circuit',
                        'icon' => 'comments',
                        'can' => 'edit-backend',
                        'submenu' => [
                            [
                                'text' => 'Preachers',
                                'url'  => 'admin/preachers',
                                'icon' => 'child',
                                'can' =>  'edit-backend'
                            ],
                            [
                                'text' => 'Societies',
                                'url'  => 'admin/societies',
                                'icon' => 'envelope-o',
                                'can' =>  'edit-backend'
                            ],
                            [
                                'text' => 'Plan',
                                'url'  => 'admin/plan/' . date('Y') . '/current/edit',
                                'icon' => 'calendar',
                                'can' =>  'edit-backend'
                            ],
                            [
                                'text' => 'Meetings',
                                'url'  => 'admin/meetings',
                                'icon' => 'group',
                                'can' =>  'edit-backend'
                            ],
                            [
                                'text' => 'Service types',
                                'url'  => 'admin/servicetypes',
                                'icon' => 'tag',
                                'can' =>  'edit-backend'
                            ],
                            [
                                'text' => 'Weekday services',
                                'url'  => 'admin/weekdays',
                                'icon' => 'tree',
                                'can' =>  'edit-backend'
                            ]
                        ]
                    ]);
                }
                if ($mods['todo_module']=="yes") {
                    $event->menu->add([
                        'text' => 'Todo',
                        'icon' => 'list-ol',
                        'can' => 'edit-backend',
                        'submenu' => [
                            [
                                'text' => 'Tasks',
                                'url'  => 'admin/actions',
                                'icon' => 'check-square-o',
                                'can' =>  'edit-backend'
                            ],
                            [
                                'text' => 'Folders',
                                'url'  => 'admin/folders',
                                'icon' => 'folder-open-o',
                                'can' =>  'admin-backend'
                            ],
                            [
                                'text' => 'Projects',
                                'url'  => 'admin/projects',
                                'icon' => 'tasks',
                                'can' =>  'edit-backend'
                            ]
                        ]
                    ]);
                }
                if ($mods['hr_module']=="yes") {
                    $event->menu->add([
                        'text' => 'Human resources',
                        'icon' => 'female',
                        'can' => 'edit-backend',
                        'submenu' => [
                            [
                                'text' => 'Staff',
                                'url'  => 'admin/staff',
                                'icon' => 'user',
                                'can' =>  'edit-backend'
                            ]
                        ]
                    ]);
                }
                if ($mods['worship_module']=="yes") {
                    $event->menu->add([
                        'text' => 'Worship',
                        'icon' => 'music',
                        'can' => 'view-worship',
                        'url' => 'admin/worship'
                    ]);
                }
                if ($mods['website_module']=="yes") {
                    $event->menu->add('WEBSITE');
                    $event->menu->add(
                        [
                        'text' => 'Blog',
                        'url' => 'admin/blogs',
                        'icon' => 'pencil-square-o',
                        'can' =>  'edit-backend'
                    ],
                    [
                        'text' => 'Sermons',
                        'url' => 'admin/series',
                        'icon' => 'microphone',
                        'can' =>  'edit-backend'
                    ],
                    [
                        'text' => 'Resources',
                        'icon' => 'thumbs-up',
                        'can' => 'edit-backend',
                        'submenu' => [
                            [
                                'text' => 'Courses',
                                'url' => 'admin/courses',
                                'icon' => 'graduation-cap',
                                'can' =>  'edit-backend'
                            ],
                            [
                                'text' => 'Lectionary',
                                'url' => 'admin/readings',
                                'icon' => 'bookmark',
                                'can' =>  'edit-backend'
                            ]
                        ]
                    ],
                    [
                        'text' => 'Site structure',
                        'icon' => 'sitemap',
                        'can' => 'admin-backend',
                        'submenu' => [
                            [
                                'text' => 'Blocks',
                                'url'  => 'admin/blocks',
                                'icon' => 'th',
                                'can' =>  'admin-backend'
                            ],
                            [
                                'text' => 'Menus',
                                'url'  => 'admin/menus',
                                'icon' => 'bars',
                                'can' =>  'admin-backend'
                            ],
                            [
                                'text' => 'Pages',
                                'url' => 'admin/pages',
                                'icon' => 'file',
                                'can' =>  'admin-backend'
                            ],
                            [
                                'text' => 'Slideshows',
                                'url' => 'admin/slideshows',
                                'icon' => 'video-camera',
                                'can' =>  'admin-backend'
                            ],
                            [
                                'text' => 'Templates',
                                'url' => 'admin/templates',
                                'icon' => 'archive',
                                'can' =>  'admin-backend'
                            ]
                        ]
                    ],
                    [
                        'text' => 'View website',
                        'url' => route('homepage'),
                        'icon' => 'globe',
                        'can' =>  'view-backend',
                        'target' => '_blank',
                        'active' => []
                    ]
                );
                }
                if ($mods['bookshop_module']=="yes") {
                    $event->menu->add([
                        'header' => 'BOOKSHOP',
                        'can' => 'edit-bookshop'
                    ]);
                    $event->menu->add(
                        [
                        'text' => 'Books',
                        'url' => 'admin/books',
                        'icon' => 'book',
                        'can' =>  'edit-bookshop'
                    ],
                    [
                        'text' => 'Suppliers',
                        'url' => 'admin/suppliers',
                        'icon' => 'archive',
                        'can' =>  'edit-bookshop'
                    ],
                    [
                        'text' => 'Transactions',
                        'url' => 'admin/transactions',
                        'icon' => 'shopping-cart',
                        'can' =>  'edit-bookshop'
                    ]
                    );
                }
                $event->menu->add([
                    'header' => 'ADMINISTRATION',
                    'can' => 'admin-backend'
                ]);
                $event->menu->add([
                    'text' => 'User administration',
                    'icon' => 'user',
                    'can' =>  'admin-backend',
                    'submenu' => [
                        [
                            'text' => 'Roles',
                            'url'  => 'admin/roles',
                            'icon' => 'eye',
                            'can' =>  'admin-backend'
                        ],
                        [
                            'text' => 'Users',
                            'url' => 'admin/users',
                            'icon' => 'user',
                            'can' =>  'admin-backend'
                        ],
                        [
                            'text' => 'Activate new users',
                            'url' => 'admin/users/activate',
                            'icon' => 'plug',
                            'can' =>  'admin-backend'
                        ],
                        [
                            'text' => 'Verify users',
                            'url' => 'admin/users/verify',
                            'icon' => 'check',
                            'can' =>  'admin-backend'
                        ]
                    ]
                ]);
                $event->menu->add([
                    'text' => 'General administration',
                    'icon' => 'cog',
                    'can' =>  'admin-backend',
                    'submenu' => [
                        [
                            'text' => 'Google Analytics',
                            'url' => 'admin/analytics',
                            'icon' => 'area-chart',
                            'can' =>  'admin-backend'
                        ],
                        [
                            'text' => 'User logs',
                            'url' => 'admin/logs',
                            'icon' => 'pencil-square-o',
                            'can' =>  'admin-backend'
                        ],
                        [
                            'text' => 'System settings',
                            'url' =>  'admin/settings',
                            'icon' => 'cogs',
                            'can' =>  'admin-backend'
                        ]
                    ]
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
            config(['adminlte.title' => $settings->getkey('site_name')]);
            config(['adminlte.logo' => $settings->getkey('site_logo')]);
            config(['adminlte.logo_mini' => $settings->getkey('site_logo_mini')]);
            config(['adminlte.plugins.datatables' => false]);
            config(['adminlte.dashboard_url' => 'admin']);
            config(['adminlte.filters' => [
                \JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
                \JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
                \JeroenNoten\LaravelAdminLte\Menu\Filters\SubmenuFilter::class,
                \JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
                \JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class]]);
            //config(['laravel-google-calendar.client_secret_json' => public_path('vendor/bishopm/client_secret.json')]);
            //config(['laravel-google-calendar.calendar_id'=>'umhlalimethodist@gmail.com']);
            config(['analytics.service_account_credentials_json' => public_path('vendor/bishopm/service_account_credentials.json')]);
            config(['analytics.view_id' => $settings->getkey('google_analytics_view_id')]);
            config(['mediable.on_duplicate' => 'Plank\Mediable\MediaUploader::ON_DUPLICATE_REPLACE']);
            config(['jwt.ttl' => 525600]);
            config(['jwt.refresh_ttl' => 525600]);
            config(['services.facebook.client_id'=> $settings->getkey('facebook_clientId')]);
            config(['services.facebook.client_secret'=> $settings->getkey('facebook_clientSecret')]);
            config(['services.facebook.redirect'=> $settings->getkey('facebook_redirect')]);
            config(['services.google.client_id'=> $settings->getkey('google_clientId')]);
            config(['services.google.client_secret'=> $settings->getkey('google_clientSecret')]);
            config(['services.google.redirect'=> $settings->getkey('google_redirect')]);
            view()->composer('connexion::templates.*', \Bishopm\Connexion\Composers\MenuComposer::class);
            view()->composer('connexion::worship.page', \Bishopm\Connexion\Composers\SongComposer::class);
            view()->composer('connexion::site.*', \Bishopm\Connexion\Composers\SlideComposer::class);
            view()->composer('connexion::posts.*', \Bishopm\Connexion\Composers\SlideComposer::class);
            view()->composer('connexion::templates.webpage_no_sidebar', \Bishopm\Connexion\Composers\SlideComposer::class);
            view()->composer('connexion::templates.sidebar_right', \Bishopm\Connexion\Composers\SlideComposer::class);
            view()->composer('connexion::templates.map_page', \Bishopm\Connexion\Composers\SlideComposer::class);

            /*// Send errors to slack channel
            $monolog = Log::getMonolog();
            if (!\App::environment('local')) {
                $slackHandler = new SlackWebhookHandler($settings->getkey('slack_webhook'), $settings->getkey('admin_slack_username'), 'App Alerts', false, 'warning', true, true, Logger::ERROR);
                $monolog->pushHandler($slackHandler);
            }*/
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands($this->commands);
        $this->app->register('Bishopm\Connexion\Providers\EventServiceProvider');
        $this->app->register('Bishopm\Connexion\Providers\ScheduleServiceProvider');
        $this->app->register('Actuallymab\LaravelComment\LaravelCommentServiceProvider');
        $this->app->register('LithiumDev\TagCloud\ServiceProvider');
        AliasLoader::getInstance()->alias("Charts", 'ConsoleTVs\Charts\Facades\Charts');
        AliasLoader::getInstance()->alias("Socialite", 'Laravel\Socialite\Facades\Socialite');
        AliasLoader::getInstance()->alias("JWTFactory", 'Tymon\JWTAuth\Facades\JWTFactory');
        AliasLoader::getInstance()->alias("JWTAuth", 'Tymon\JWTAuth\Facades\JWTAuth');
        AliasLoader::getInstance()->alias("UserVerification", 'Jrean\UserVerification\Facades\UserVerification');
        AliasLoader::getInstance()->alias("GoogleCalendar", 'Spatie\GoogleCalendar\GoogleCalendarFacade');
        AliasLoader::getInstance()->alias("Form", 'Collective\Html\FormFacade');
        AliasLoader::getInstance()->alias("HTML", 'Collective\Html\HtmlFacade');
        AliasLoader::getInstance()->alias("Menu", 'Nwidart\Menus\Facades\Menu');
        AliasLoader::getInstance()->alias("MediaUploader", 'Plank\Mediable\MediaUploaderFacade');
        AliasLoader::getInstance()->alias("Feed", 'Roumen\Feed\Feed');
        AliasLoader::getInstance()->alias("Analytics", 'Spatie\Analytics\AnalyticsFacade');
        $this->app['router']->aliasMiddleware('isverified', 'Bishopm\Connexion\Middleware\IsVerified');
        $this->app['router']->aliasMiddleware('handlecors', 'Barryvdh\Cors\HandleCors');
        $this->app['router']->aliasMiddleware('jwt.auth', 'Tymon\JWTAuth\Middleware\GetUserFromToken');
        $this->registerBindings();
        $this->registerUserPolicies();
    }

    public function registerUserPolicies()
    {
        Gate::define('admin-backend', function ($user) {
            return $user->hasAccess(['admin-backend']);
        });
        Gate::define('edit-backend', function ($user) {
            return $user->hasAccess(['edit-backend']);
        });
        Gate::define('view-backend', function ($user) {
            return $user->hasAccess(['view-backend']);
        });
        Gate::define('edit-comments', function ($user) {
            return $user->hasAccess(['edit-comments']);
        });
        Gate::define('edit-worship', function ($user) {
            return $user->hasAccess(['edit-worship']);
        });
        Gate::define('view-worship', function ($user) {
            return $user->hasAccess(['view-worship']);
        });
        Gate::define('edit-bookshop', function ($user) {
            return $user->hasAccess(['edit-bookshop']);
        });
        Gate::define('admin-giving', function ($user) {
            return $user->hasAccess(['admin-giving']);
        });
        Gate::define('manager-role', function ($user) {
            return $user->inRole('manager');
        });
        Gate::define('administrator-role', function ($user) {
            return $user->inRole('administrator');
        });
        Gate::define('bookshop-manager-role', function ($user) {
            return $user->inRole('bookshop-manager');
        });
    }

    private function initialiseSettings()
    {
        $settings=array(
            ['setting_key'=>'admin_slack_username','module'=>'core','description'=>'Admin user Slack username for notifications','setting_value'=>'Slack username'],
            ['setting_key'=>'bibles_api_key','module'=>'website','description'=>'Private API key for bibles.org','setting_value'=>'Bible API key'],
            ['setting_key'=>'bibles_api_user','module'=>'website','description'=>'API username for bibles.org','setting_value'=>'Bible API username'],
            ['setting_key'=>'birthday_group','module'=>'core','description'=>'Group whose members receive birthday emails each week','setting_value'=>'Birthday group'],
            ['setting_key'=>'bookshop','module'=>'bookshop','description'=>'Bookshop group','setting_value'=>'Bookshop group'],
            ['setting_key'=>'bookshop_manager','module'=>'bookshop','description'=>'Individual who will receive a copy of book orders in addition to the main church email address','setting_value'=>'Bookshop manager'],
            ['setting_key'=>'church_address','module'=>'website','description'=>'Church physical address','setting_value'=>'Church address'],
            ['setting_key'=>'church_api_url','module'=>'mcsa','description'=>'API for centralised church data','setting_value'=>'Church API'],
            ['setting_key'=>'church_api_token','module'=>'mcsa','description'=>'Token for centralised church data API','setting_value'=>''],
            ['setting_key'=>'church_email','module'=>'website','description'=>'Church email address','setting_value'=>'Email address'],
            ['setting_key'=>'church_phone','module'=>'website','description'=>'Church office phone number','setting_value'=>'Office phone number'],
            ['setting_key'=>'church_mission','module'=>'website','description'=>'Church mission statement','setting_value'=>'Church mission statement'],
            ['setting_key'=>'circuit','module'=>'mcsa','description'=>'Circuit','setting_value'=>''],
            ['setting_key'=>'colour_primary','module'=>'website','description'=>'Primary website colour','setting_value'=>'blue'],
            ['setting_key'=>'colour_secondary','module'=>'website','description'=>'Secondary website colour (darker)','setting_value'=>'navy'],
            ['setting_key'=>'colour_tertiary','module'=>'website','description'=>'Tertiary website colour (lighter)','setting_value'=>'lightblue'],
            ['setting_key'=>'facebook_page','module'=>'website','description'=>'Church Facebook page url','setting_value'=>'Facebook page'],
            ['setting_key'=>'facebook_clientId','module'=>'core','description'=>'Facebook Client ID','setting_value'=>'Facebook Client ID'],
            ['setting_key'=>'facebook_clientSecret','module'=>'core','description'=>'Facebook Client Secret','setting_value'=>'Facebook Client Secret'],
            ['setting_key'=>'facebook_redirect','module'=>'website','description'=>'Facebook Redirect url','setting_value'=>'Facebook Redirect url'],
            ['setting_key'=>'filtered_tasks','module'=>'todo','description'=>'Filter tasks','setting_value'=>'Next actions'],
            ['setting_key'=>'giving_administrator','module'=>'core','description'=>'Person who has exclusive access to planned giving details','setting_value'=>'Giving administrator'],
            ['setting_key'=>'giving_lagtime','module'=>'core','description'=>'Number of days before reports go out that administrator gets a warning email','setting_value'=>'Lag time in days'],
            ['setting_key'=>'giving_reports','module'=>'core','description'=>'How many giving reports per year','setting_value'=>'Number of reports'],
            ['setting_key'=>'google_analytics_view_id','module'=>'core','description'=>'View ID for Google Analytics API','setting_value'=>'Google analytics API'],
            ['setting_key'=>'google_api','module'=>'core','description'=>'Google API for maps','setting_value'=>'Google maps API'],
            ['setting_key'=>'google_calendar','module'=>'core','description'=>'Church Google calendar','setting_value'=>'Google calendar ID'],
            ['setting_key'=>'google_clientId','module'=>'core','description'=>'Google Client ID','setting_value'=>'Google Client ID'],
            ['setting_key'=>'google_clientSecret','module'=>'core','description'=>'Google Client Secret','setting_value'=>'Google Client Secret'],
            ['setting_key'=>'google_redirect','module'=>'website','description'=>'Google Redirect url','setting_value'=>'Google Redirect url'],
            ['setting_key'=>'home_latitude','module'=>'core','description'=>'Church location: latitude','setting_value'=>'Church latitude'],
            ['setting_key'=>'home_longitude','module'=>'core','description'=>'Church location: longitude','setting_value'=>'Church longitude'],
            ['setting_key'=>'mail_encryption','module'=>'core','description'=>'Email settings: email account encryption (or leave as null)','setting_value'=>''],
            ['setting_key'=>'mail_host','module'=>'core','description'=>'Email settings: host name','setting_value'=>'host name'],
            ['setting_key'=>'mail_password','module'=>'core','description'=>'Email settings: email account password','setting_value'=>'email password'],
            ['setting_key'=>'mail_port','module'=>'core','description'=>'Email settings: port number','setting_value'=>'email port'],
            ['setting_key'=>'mail_username','module'=>'core','description'=>'Email settings: email account username','setting_value'=>'email username'],
            ['setting_key'=>'pastoral_group','module'=>'core','description'=>'Pastoral team group','setting_value'=>'Pastoral group'],
            ['setting_key'=>'qr_code','module'=>'website','description'=>'URL of QR code image','setting_value'=>'QR code url'],
            ['setting_key'=>'searchengine_keywords','module'=>'website','description'=>'Search engine keywords for meta tags','setting_value'=>'Search engine keywords'],
            ['setting_key'=>'site_abbreviation','module'=>'core','description'=>'Church name abbreviated','setting_value'=>'Abbreviated church name'],
            ['setting_key'=>'site_description','module'=>'website','description'=>'Site description','setting_value'=>'Slogan or vision statement'],
            ['setting_key'=>'site_logo','module'=>'core','description'=>'Text logo in menu bar','setting_value'=>'<b>C</b>onnexion'],
            ['setting_key'=>'site_logo_mini','module'=>'core','description'=>'Text logo when sidebar is collapsed','setting_value'=>'<b>C</b>x'],
            ['setting_key'=>'site_name','module'=>'core','description'=>'Church name','setting_value'=>'Church name'],
            ['setting_key'=>'slack_webhook','module'=>'core','description'=>'Slack Webhook for notifications','setting_value'=>'Slack webhook'],
            ['setting_key'=>'sms_password','module'=>'core','description'=>'SMS password','setting_value'=>'SMS password'],
            ['setting_key'=>'sms_provider','module'=>'core','description'=>'Choose either bulksms or smsfactory','setting_value'=>'SMS provider'],
            ['setting_key'=>'sms_username','module'=>'core','description'=>'SMS username','setting_value'=>'SMS username'],
            ['setting_key'=>'society_name','module'=>'core','description'=>'Name of society (must set up societies first)','setting_value'=>'Society name'],
            ['setting_key'=>'sunday_roster','module'=>'core','description'=>'Roster for Sunday service teams','setting_value'=>'Sunday serving teams roster'],
            ['setting_key'=>'twitter_profile','module'=>'website','description'=>'Church Twitter profile','setting_value'=>'Twitter profile'],
            ['setting_key'=>'website_theme','module'=>'website','description'=>'Website theme','setting_value'=>'navy'],
            ['setting_key'=>'worship_services','module'=>'worship','description'=>'Service times when music sets are used - comma separated list','setting_value'=>'09h00,18h00'],
            ['setting_key'=>'worship_administrator','module'=>'worship','description'=>'Individual who receives set emails and prepares the PC for services','setting_value'=>'Worship administrator'],
            ['setting_key'=>'youtube_page','module'=>'website','description'=>'Church Youtube page','setting_value'=>'Youtube page']
        );
        $existing=array_flatten(Setting::select('setting_key')->get()->toArray());
        foreach ($settings as $ss) {
            if (!in_array($ss['setting_key'], $existing)) {
                $this->settings->create($ss);
            }
        }
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
            'Bishopm\Connexion\Repositories\BlocksRepository',
            function () {
                $repository = new \Bishopm\Connexion\Repositories\BlocksRepository(new \Bishopm\Connexion\Models\Block());
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
            'Bishopm\Connexion\Repositories\BooksRepository',
            function () {
                $repository = new \Bishopm\Connexion\Repositories\BooksRepository(new \Bishopm\Connexion\Models\Book());
                return $repository;
            }
        );
        $this->app->bind(
            'Bishopm\Connexion\Repositories\CircuitsRepository',
            function () {
                $repository = new \Bishopm\Connexion\Repositories\CircuitsRepository('circuits');
                return $repository;
            }
        );
        $this->app->bind(
            'Bishopm\Connexion\Repositories\CommentsRepository',
            function () {
                $repository = new \Bishopm\Connexion\Repositories\CommentsRepository(new \Actuallymab\LaravelComment\Models\Comment());
                return $repository;
            }
        );
        $this->app->bind(
            'Bishopm\Connexion\Repositories\CoursesRepository',
            function () {
                $repository = new \Bishopm\Connexion\Repositories\CoursesRepository(new \Bishopm\Connexion\Models\Course());
                return $repository;
            }
        );
        $this->app->bind(
            'Bishopm\Connexion\Repositories\EmployeesRepository',
            function () {
                $repository = new \Bishopm\Connexion\Repositories\EmployeesRepository(new \Bishopm\Connexion\Models\Employee());
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
                $repository = new \Bishopm\Connexion\Repositories\MeetingsRepository('meetings');
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
            'Bishopm\Connexion\Repositories\MessagesRepository',
            function () {
                $repository = new \Bishopm\Connexion\Repositories\MessagesRepository(new \Bishopm\Connexion\Models\Message());
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
            'Bishopm\Connexion\Repositories\PaymentsRepository',
            function () {
                $repository = new \Bishopm\Connexion\Repositories\PaymentsRepository(new \Bishopm\Connexion\Models\Payment());
                return $repository;
            }
        );
        $this->app->bind(
            'Bishopm\Connexion\Repositories\PlansRepository',
            function () {
                $repository = new \Bishopm\Connexion\Repositories\PlansRepository('plans');
                return $repository;
            }
        );
        $this->app->bind(
            'Bishopm\Connexion\Repositories\PostsRepository',
            function () {
                $repository = new \Bishopm\Connexion\Repositories\PostsRepository(new \Bishopm\Connexion\Models\Post());
                return $repository;
            }
        );
        $this->app->bind(
            'Bishopm\Connexion\Repositories\PreachersRepository',
            function () {
                $repository = new \Bishopm\Connexion\Repositories\PreachersRepository('preachers');
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
            'Bishopm\Connexion\Repositories\RostersRepository',
            function () {
                $repository = new \Bishopm\Connexion\Repositories\RostersRepository(new \Bishopm\Connexion\Models\Roster());
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
                $repository = new \Bishopm\Connexion\Repositories\ServicesRepository('services');
                return $repository;
            }
        );
        $this->app->bind(
            'Bishopm\Connexion\Repositories\ServicetypesRepository',
            function () {
                $repository = new \Bishopm\Connexion\Repositories\ServicetypesRepository('tags');
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
            'Bishopm\Connexion\Repositories\SlideshowsRepository',
            function () {
                $repository = new \Bishopm\Connexion\Repositories\SlideshowsRepository(new \Bishopm\Connexion\Models\Slideshow());
                return $repository;
            }
        );
        $this->app->bind(
            'Bishopm\Connexion\Repositories\SocietiesRepository',
            function () {
                $repository = new \Bishopm\Connexion\Repositories\SocietiesRepository('societies');
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
            'Bishopm\Connexion\Repositories\StatisticsRepository',
            function () {
                $repository = new \Bishopm\Connexion\Repositories\StatisticsRepository(new \Bishopm\Connexion\Models\Statistic());
                return $repository;
            }
        );
        $this->app->bind(
            'Bishopm\Connexion\Repositories\SuppliersRepository',
            function () {
                $repository = new \Bishopm\Connexion\Repositories\SuppliersRepository(new \Bishopm\Connexion\Models\Supplier());
                return $repository;
            }
        );
        $this->app->bind(
            'Bishopm\Connexion\Repositories\TransactionsRepository',
            function () {
                $repository = new \Bishopm\Connexion\Repositories\TransactionsRepository(new \Bishopm\Connexion\Models\Transaction());
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
                $repository = new \Bishopm\Connexion\Repositories\WeekdaysRepository('weekdays');
                return $repository;
            }
        );
    }
}
