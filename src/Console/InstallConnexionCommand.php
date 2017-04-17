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
        $this->call('vendor:publish');
        $this->info('Setting up database tables');
        $this->call('migrate');
        $users=User::all();
        if (count($users)){
            $this->info('This command may only be run on a blank installation. Exiting ...');
        } else {
            $newuser=New User;
            $newuser->name=$this->ask('Enter username of administrative user');
            $newuser->email=$this->ask('Enter administrative user email address');
            $newuser->password=Hash::make($this->secret('Enter administrative user password'));
            $this->info('Creating new administrative user...');
            $newuser->verified=1;
            $newuser->save();          
            $this->seeder();
            $this->call('storage:link');
            $this->call('cache:clear');
        }
    }

    protected function seeder()
    {
        DB::table('roles')->insert([
            'name' => 'administrator'
        ]);
        DB::table('roles')->insert([
            'name' => 'web-user'
        ]);
        DB::table('permissions')->insert([
            'name' => 'admin-backend'
        ]);
        DB::table('permissions')->insert([
            'name' => 'edit-comment'
        ]);
        DB::table('permissions')->insert([
            'name' => 'view-backend'
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
            'role_id' => '2',
            'permission_id' => '2'
        ]);
        DB::table('permission_role')->insert([
            'role_id' => '2',
            'permission_id' => '4'
        ]);
        DB::table('role_user')->insert([
            'role_id' => '1',
            'user_id' => '1',
            'user_type' => 'Bishopm\Connexion\Models\User'
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
            'setting_key' => 'church_email',
            'setting_value' => 'info@church.com',
            'category' => 'general'
        ]); 
        DB::table('settings')->insert([
            'setting_key' => 'church_address',
            'setting_value' => 'Church address',
            'category' => 'general'
        ]); 
        DB::table('settings')->insert([
            'setting_key' => 'facebook_page',
            'setting_value' => 'http://www.facebook.com',
            'category' => 'general'
        ]); 
        DB::table('settings')->insert([
            'setting_key' => 'twitter_profile',
            'setting_value' => 'http://www.twitter.com',
            'category' => 'general'
        ]); 
        DB::table('settings')->insert([
            'setting_key' => 'youtube_page',
            'setting_value' => 'http://www.youtube.com',
            'category' => 'general'
        ]);
        DB::table('settings')->insert([
            'setting_key' => 'church_phone',
            'setting_value' => 'Office number',
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
        DB::table('settings')->insert([
            'setting_key' => 'presiding_bishop',
            'setting_value' => '',
            'description' => 'Presiding Bishop name',
            'category' => 'circuit'
        ]);
        DB::table('settings')->insert([
            'setting_key' => 'general_secretary',
            'setting_value' => '',
            'description' => 'General Secretary name',
            'category' => 'circuit'
        ]);
        DB::table('settings')->insert([
            'setting_key' => 'district_bishop',
            'setting_value' => '',
            'description' => 'District Bishop name',
            'category' => 'circuit'
        ]);
        DB::table('settings')->insert([
            'setting_key' => 'superintendent',
            'setting_value' => '',
            'description' => 'Superintendent name',
            'category' => 'circuit'
        ]);
        DB::table('settings')->insert([
            'setting_key' => 'circuit_name',
            'setting_value' => '',
            'description' => 'Circuit name',
            'category' => 'circuit'
        ]);
        DB::table('settings')->insert([
            'setting_key' => 'circuit_number',
            'setting_value' => '',
            'description' => 'Circuit number',
            'category' => 'circuit'
        ]);
    }
}
