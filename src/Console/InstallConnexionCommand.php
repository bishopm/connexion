<?php

namespace Bishopm\Connexion\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Bishopm\Connexion\Models\User;
use Illuminate\Support\Facades\DB;

class InstallConnexionCommand extends Command
{
    protected $signature = 'connexion:install';
    protected $description = 'Initial setup of Connexion Application';

    public function handle()
    {
        $this->info('Setting up database tables');
        $this->call('vendor:publish');
        $this->call('migrate');
        $users=User::all();
        if (count($users)){
            $this->info('This command may only be run on a blank installation. Exiting ...');
        } else {
            $newuser=New User;
            $newuser->name=$this->ask('Enter name of administrative user');
            $newuser->email=$this->ask('Enter user email address');
            $newuser->password=Hash::make($this->secret('Enter user password'));
            $this->info('Creating new administrative user...');
            $newuser->save();          
            $this->seeder();
            $this->call('storage:link');
            $this->call('cache:clear');
        }
    }

    protected function seeder()
    {
        DB::table('roles')->insert([
            'name' => 'admin'
        ]);
        DB::table('roles')->insert([
            'name' => 'editor'
        ]);
        DB::table('roles')->insert([
            'name' => 'backend'
        ]);
        DB::table('permissions')->insert([
            'name' => 'administer-site'
        ]);
        DB::table('permissions')->insert([
            'name' => 'read-content'
        ]);
        DB::table('permissions')->insert([
            'name' => 'edit-content'
        ]);
        DB::table('role_has_permissions')->insert([
            'role_id' => '1',
            'permission_id' => '1'
        ]);
        DB::table('role_has_permissions')->insert([
            'role_id' => '1',
            'permission_id' => '2'
        ]);
        DB::table('role_has_permissions')->insert([
            'role_id' => '1',
            'permission_id' => '3'
        ]);
        DB::table('role_has_permissions')->insert([
            'role_id' => '2',
            'permission_id' => '2'
        ]);
        DB::table('role_has_permissions')->insert([
            'role_id' => '2',
            'permission_id' => '3'
        ]);
        DB::table('role_has_permissions')->insert([
            'role_id' => '3',
            'permission_id' => '3'
        ]);
        DB::table('user_has_roles')->insert([
            'role_id' => '1',
            'user_id' => '1'
        ]);
        DB::table('settings')->insert([
            'setting_key' => 'site_name',
            'setting_value' => 'Connexion',
            'category' => 'general'
        ]);
        DB::table('settings')->insert([
            'setting_key' => 'society_name',
            'setting_value' => '',
            'category' => 'general'
        ]); 
        DB::table('settings')->insert([
            'setting_key' => 'google_calendar',
            'setting_value' => '',
            'category' => 'calendar'
        ]);         
        DB::table('settings')->insert([
            'setting_key' => 'site_abbreviation',
            'setting_value' => 'Cx',
            'category' => 'general'
        ]);
        DB::table('settings')->insert([
            'setting_key' => 'site_logo',
            'setting_value' => '<b>Connexion</b>Site',
            'category' => 'general'
        ]); 
        DB::table('settings')->insert([
            'setting_key' => 'site_logo_mini',
            'setting_value' => '<b>C</b>x',
            'category' => 'general'
        ]); 
        DB::table('settings')->insert([
            'setting_key' => 'society',
            'setting_value' => '',
            'category' => 'general'
        ]);         
        DB::table('settings')->insert([
            'setting_key' => 'google_api',
            'setting_value' => 'AIzaSyBQmfbfWGd1hxfR1sbnRXdCaQ5Mx5FjUhA',
            'category' => 'maps'
        ]);
        DB::table('settings')->insert([
            'setting_key' => 'home_latitude',
            'setting_value' => '-29.481602708198054',
            'category' => 'maps'
        ]);
        DB::table('settings')->insert([
            'setting_key' => 'home_longitude',
            'setting_value' => '31.222890615408687',
            'category' => 'maps'
        ]);        
        DB::table('settings')->insert([
            'setting_key' => 'toodledo_clientid',
            'setting_value' => '',
            'category' => 'tasks'
        ]);
        DB::table('settings')->insert([
            'setting_key' => 'toodledo_secret',
            'setting_value' => '',
            'category' => 'tasks'
        ]);                
        DB::table('settings')->insert([
            'setting_key' => 'toodledo_redirect_uri',
            'setting_value' => '',
            'category' => 'tasks'
        ]);
        DB::table('settings')->insert([
            'setting_key' => 'website_theme',
            'setting_value' => 'umhlali',
            'category' => 'website'
        ]);
        // Modules
        DB::table('settings')->insert([
            'setting_key' => 'core_module',
            'setting_value' => 'yes',
            'description' => 'Church membership data - individuals, households and groups, together with email and sms facilities and reporting',
            'category' => 'modules'
        ]);
        DB::table('settings')->insert([
            'setting_key' => 'worship_module',
            'setting_value' => 'yes',
            'description' => 'Stores liturgy and songs (with guitar chords), creates service sets and tracks song / liturgy usage',
            'category' => 'modules'
        ]);
        DB::table('settings')->insert([
            'setting_key' => 'todo_module',
            'setting_value' => 'yes',
            'description' => 'Task and project management module with an optional connection to the Toodledo web interface and mobile apps',
            'category' => 'modules'
        ]);
        DB::table('settings')->insert([
            'setting_key' => 'website_module',
            'setting_value' => 'yes',
            'description' => 'Backend module to create a website, including blog, slides, group resources, sermon audio',
            'category' => 'modules'
        ]);
        DB::table('settings')->insert([
            'setting_key' => 'circuit_preachers',
            'setting_value' => 'yes',
            'description' => 'Collects names of preachers and circuit ministers and includes the quarterly preaching plan',
            'category' => 'modules'
        ]);
    }
}
