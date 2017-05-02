<?php

namespace Bishopm\Connexion\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Bishopm\Connexion\Models\User;
use Bishopm\Connexion\Models\Household;
use Bishopm\Connexion\Models\Individual;
use Illuminate\Support\Facades\DB;

class InstallConnexionCommand extends Command
{
    protected $signature = 'connexion:install';
    protected $description = 'Initial setup of Connexion Application';

    public function handle()
    {
        $this->call('vendor:publish');
        $this->info('Setting up database tables - this may take a minute...');
        $this->call('migrate');
        $users=User::all();
        if (count($users)){
            $this->info('This command may only be run on a blank installation. Exiting ...');
        } else {
            $newuser=New User;
            $newhousehold=New Household;
            $newindiv=New Individual;
            $this->info('We will now set up an admin user, who will also be included in the membership database');
            $newindiv->title=$this->choice('What is the title of the admin user?', ['Mr', 'Ms','Mrs']);
            if ($newindiv->title=="Mr"){
                $newindiv->sex="male";
            } else {
                $newindiv->sex="female";
            }
            $newindiv->firstname=$this->ask('What is the first name of the admin user?');
            $newindiv->surname=$this->ask('What is the surname of the admin user?');
            $newhousehold->sortsurname=$newindiv->surname;
            $newhousehold->addressee=$newindiv->title . " " . $newindiv->firstname . " " . $newindiv->surname;
            $newhousehold->latitude=0;
            $newhousehold->longitude=0;
            $newhousehold->save();
            $newindiv->household_id=$newhousehold->id;
            $newuser->name=$this->ask('Enter username of administrative user');
            $newuser->email=$this->ask('Enter administrative user email address');
            $newindiv->email=$newuser->email;
            $newindiv->save();
            $newuser->password=Hash::make($this->secret('Enter administrative user password'));
            $this->info('Creating new administrative user...');
            $newuser->verified=1;
            $newuser->individual_id=$newindiv->id;
            $newuser->save();
            $this->seeder();
            $this->call('storage:link');
            $this->call('cache:clear');
        }
    }

    protected function seeder()
    {
        DB::table('menus')->insert([
            'menu' => 'main',
            'description' => 'Main website menu'
        ]);
        DB::table('tags')->insert([
            'namespace' => 'Bishopm\Connexion\Models\Individual',
            'slug' => 'preacher',
            'name' => 'preacher'
        ]);
        DB::table('tags')->insert([
            'namespace' => 'Bishopm\Connexion\Models\Individual',
            'slug' => 'staff',
            'name' => 'staff'
        ]);
        DB::table('tags')->insert([
            'namespace' => 'Bishopm\Connexion\Models\Individual',
            'slug' => 'blogger',
            'name' => 'blogger'
        ]);
        DB::table('menuitems')->insert([
            'menu_id' => 1,
            'parent_id' => 0,
            'title' => 'Books',
            'url' => 'books',
            'target' => '_self'
        ]);
        DB::table('menuitems')->insert([
            'menu_id' => 1,
            'parent_id' => 0,
            'title' => 'Courses',
            'url' => 'courses',
            'target' => '_self'
        ]);
        DB::table('menuitems')->insert([
            'menu_id' => 1,
            'parent_id' => 0,
            'title' => 'Groups',
            'url' => 'groups',
            'target' => '_self'
        ]);
        DB::table('menuitems')->insert([
            'menu_id' => 1,
            'parent_id' => 0,
            'title' => 'Sermons',
            'url' => 'sermons',
            'target' => '_self'
        ]);
        DB::table('roles')->insert([
            'name' => 'administrator'
        ]);
        DB::table('roles')->insert([
            'name' => 'web-user'
        ]);
        DB::table('roles')->insert([
            'name' => 'bookshop-manager'
        ]);
        DB::table('roles')->insert([
            'name' => 'manager'
        ]);
        DB::table('permissions')->insert([
            'name' => 'admin-backend'
        ]);
        DB::table('permissions')->insert([
            'name' => 'edit-comment'
        ]);
        DB::table('permissions')->insert([
            'name' => 'edit-backend'
        ]);
        DB::table('permissions')->insert([
            'name' => 'view-backend'
        ]);
        DB::table('permissions')->insert([
            'name' => 'edit-worship'
        ]);
        DB::table('permissions')->insert([
            'name' => 'edit-bookshop'
        ]);
        DB::table('permissions')->insert([
            'name' => 'view-worship'
        ]);
        DB::table('permission_role')->insert([
            'role_id' => '1',
            'permission_id' => '1'
        ]);
        DB::table('permission_role')->insert([
            'role_id' => '1',
            'permission_id' => '2'
        ]);
        DB::table('permission_role')->insert([
            'role_id' => '1',
            'permission_id' => '3'
        ]);
        DB::table('permission_role')->insert([
            'role_id' => '1',
            'permission_id' => '4'
        ]);
        DB::table('permission_role')->insert([
            'role_id' => '1',
            'permission_id' => '5'
        ]);
        DB::table('permission_role')->insert([
            'role_id' => '1',
            'permission_id' => '6'
        ]);
        DB::table('permission_role')->insert([
            'role_id' => '1',
            'permission_id' => '7'
        ]);
        DB::table('permission_role')->insert([
            'role_id' => '2',
            'permission_id' => '2'
        ]);
        DB::table('permission_role')->insert([
            'role_id' => '3',
            'permission_id' => '3'
        ]);
        DB::table('permission_role')->insert([
            'role_id' => '3',
            'permission_id' => '4'
        ]);
        DB::table('permission_role')->insert([
            'role_id' => '3',
            'permission_id' => '5'
        ]);
        DB::table('permission_role')->insert([
            'role_id' => '3',
            'permission_id' => '6'
        ]);
        DB::table('permission_role')->insert([
            'role_id' => '3',
            'permission_id' => '7'
        ]);
        DB::table('permission_role')->insert([
            'role_id' => '4',
            'permission_id' => '2'
        ]);
        DB::table('permission_role')->insert([
            'role_id' => '4',
            'permission_id' => '3'
        ]);
        DB::table('permission_role')->insert([
            'role_id' => '4',
            'permission_id' => '4'
        ]);
        DB::table('permission_role')->insert([
            'role_id' => '4',
            'permission_id' => '5'
        ]);
        DB::table('permission_role')->insert([
            'role_id' => '4',
            'permission_id' => '6'
        ]);
        DB::table('permission_role')->insert([
            'role_id' => '4',
            'permission_id' => '7'
        ]);
        DB::table('role_user')->insert([
            'role_id' => '1',
            'user_id' => '1',
            'user_type' => 'Bishopm\Connexion\Models\User'
        ]);
        DB::table('settings')->insert([
            'setting_key' => 'site_name',
            'setting_value' => 'Connexion',
            'description' => 'Website name',
            'category' => 'General'
        ]);
        DB::table('settings')->insert([
            'setting_key' => 'society_name',
            'setting_value' => '',
            'description' => 'Name of society (must set up societies first)',
            'category' => 'General'
        ]);
        DB::table('settings')->insert([
            'setting_key' => 'church_email',
            'setting_value' => 'info@church.com',
            'description' => 'Church email address',
            'category' => 'General'
        ]); 
        DB::table('settings')->insert([
            'setting_key' => 'church_address',
            'setting_value' => 'Church address',
            'description' => 'Church physical address',
            'category' => 'General'
        ]); 
        DB::table('settings')->insert([
            'setting_key' => 'facebook_page',
            'setting_value' => 'http://www.facebook.com',
            'description' => 'Church Facebook page url',
            'category' => 'General'
        ]); 
        DB::table('settings')->insert([
            'setting_key' => 'twitter_profile',
            'setting_value' => 'http://www.twitter.com',
            'description' => 'Church Twitter profile',
            'category' => 'General'
        ]); 
        DB::table('settings')->insert([
            'setting_key' => 'youtube_page',
            'setting_value' => 'http://www.youtube.com',
            'description' => 'Church Youtube page',
            'category' => 'General'
        ]);
        DB::table('settings')->insert([
            'setting_key' => 'church_phone',
            'setting_value' => 'Office number',
            'description' => 'Church office phone number',
            'category' => 'General'
        ]);
        DB::table('settings')->insert([
            'setting_key' => 'sms_provider',
            'setting_value' => '',
            'description' => 'Choose either bulksms or smsfactory',
            'category' => 'SMS'
        ]);
        DB::table('settings')->insert([
            'setting_key' => 'sms_username',
            'setting_value' => '',
            'description' => 'SMS username',
            'category' => 'SMS'
        ]);
        DB::table('settings')->insert([
            'setting_key' => 'sms_password',
            'setting_value' => '',
            'description' => 'SMS password',
            'category' => 'SMS'
        ]); 
        DB::table('settings')->insert([
            'setting_key' => 'google_calendar',
            'setting_value' => '',
            'description' => 'Church Google calendar',
            'category' => 'Calendar'
        ]);         
        DB::table('settings')->insert([
            'setting_key' => 'site_abbreviation',
            'setting_value' => 'Cx',
            'description' => 'Church name abbreviated',
            'category' => 'General'
        ]);
        DB::table('settings')->insert([
            'setting_key' => 'site_logo',
            'setting_value' => '<b>Connexion</b>Site',
            'description' => 'Text logo in menu bar',
            'category' => 'General'
        ]); 
        DB::table('settings')->insert([
            'setting_key' => 'site_logo_mini',
            'setting_value' => '<b>C</b>x',
            'description' => 'Text logo when sidebar is collapsed',
            'category' => 'General'
        ]); 
        DB::table('settings')->insert([
            'setting_key' => 'google_api',
            'setting_value' => 'AIzaSyBQmfbfWGd1hxfR1sbnRXdCaQ5Mx5FjUhA',
            'description' => 'Google API for maps',
            'category' => 'API'
        ]);
        DB::table('settings')->insert([
            'setting_key' => 'home_latitude',
            'setting_value' => '-29.481602708198054',
            'description' => 'Church location: latitude',
            'category' => 'Maps'
        ]);
        DB::table('settings')->insert([
            'setting_key' => 'home_longitude',
            'setting_value' => '31.222890615408687',
            'description' => 'Church location: longitude',
            'category' => 'Maps'
        ]);        
        DB::table('settings')->insert([
            'setting_key' => 'toodledo_clientid',
            'setting_value' => '',
            'description' => 'Toodledo client id',
            'category' => 'API'
        ]);
        DB::table('settings')->insert([
            'setting_key' => 'toodledo_secret',
            'setting_value' => '',
            'description' => 'Toodledo secret',
            'category' => 'API'
        ]);                
        DB::table('settings')->insert([
            'setting_key' => 'toodledo_redirect_uri',
            'setting_value' => '',
            'description' => 'Toodledo redirect url',
            'category' => 'API'
        ]);
        DB::table('settings')->insert([
            'setting_key' => 'website_theme',
            'setting_value' => 'umhlali',
            'description' => 'Website theme',
            'category' => 'website'
        ]);
        DB::table('settings')->insert([
            'setting_key' => 'mail_encryption',
            'setting_value' => 'null',
            'description' => 'Email settings: email account encryption (or leave as null)',
            'category' => 'Email'
        ]);
        DB::table('settings')->insert([
            'setting_key' => 'mail_host',
            'setting_value' => '',
            'description' => 'Email settings: host name',
            'category' => 'Email'
        ]);
        DB::table('settings')->insert([
            'setting_key' => 'mail_password',
            'setting_value' => '',
            'description' => 'Email settings: email account password',
            'category' => 'Email'
        ]);
        DB::table('settings')->insert([
            'setting_key' => 'mail_port',
            'setting_value' => '25',
            'description' => 'Email settings: port number',
            'category' => 'Email'
        ]);
        DB::table('settings')->insert([
            'setting_key' => 'mail_username',
            'setting_value' => '',
            'description' => 'Email settings: email account username',
            'category' => 'Email'
        ]);
        DB::table('settings')->insert([
            'setting_key' => 'presiding_bishop',
            'setting_value' => '',
            'description' => 'Presiding Bishop name',
            'category' => 'Circuit'
        ]);
        DB::table('settings')->insert([
            'setting_key' => 'general_secretary',
            'setting_value' => '',
            'description' => 'General Secretary name',
            'category' => 'Circuit'
        ]);
        DB::table('settings')->insert([
            'setting_key' => 'district_bishop',
            'setting_value' => '',
            'description' => 'District Bishop name',
            'category' => 'Circuit'
        ]);
        DB::table('settings')->insert([
            'setting_key' => 'superintendent',
            'setting_value' => '',
            'description' => 'Superintendent name',
            'category' => 'Circuit'
        ]);
        DB::table('settings')->insert([
            'setting_key' => 'circuit_name',
            'setting_value' => '',
            'description' => 'Circuit name',
            'category' => 'Circuit'
        ]);
        DB::table('settings')->insert([
            'setting_key' => 'circuit_number',
            'setting_value' => '',
            'description' => 'Circuit number',
            'category' => 'Circuit'
        ]);
        DB::table('settings')->insert([
            'setting_key' => 'pastoral_group',
            'setting_value' => '',
            'description' => 'Pastoral team group',
            'category' => 'General'
        ]);
        // Modules
        DB::table('settings')->insert([
            'setting_key' => 'core_module',
            'setting_value' => 'yes',
            'description' => 'Church membership data - individuals, households and groups, together with email and sms facilities and reporting',
            'category' => 'Modules'
        ]);
        DB::table('settings')->insert([
            'setting_key' => 'worship_module',
            'setting_value' => 'yes',
            'description' => 'Stores liturgy and songs (with guitar chords), creates service sets and tracks song / liturgy usage',
            'category' => 'Modules'
        ]);
        DB::table('settings')->insert([
            'setting_key' => 'todo_module',
            'setting_value' => 'yes',
            'description' => 'Task and project management module with an optional connection to the Toodledo web interface and mobile apps',
            'category' => 'Modules'
        ]);
        DB::table('settings')->insert([
            'setting_key' => 'website_module',
            'setting_value' => 'yes',
            'description' => 'Backend module to create a website, including blog, slides, group resources, sermon audio',
            'category' => 'Modules'
        ]);
        DB::table('settings')->insert([
            'setting_key' => 'circuit_preachers',
            'setting_value' => 'yes',
            'description' => 'Collects names of preachers and circuit ministers and includes the quarterly preaching plan',
            'category' => 'Modules'
        ]);
    }
}
