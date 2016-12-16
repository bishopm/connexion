<?php

namespace bishopm\base\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use bishopm\base\Models\User;
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
            'setting_key' => 'google_api',
            'setting_value' => '',
            'category' => 'maps'
        ]);
        DB::table('settings')->insert([
            'setting_key' => 'home_latitude',
            'setting_value' => '',
            'category' => 'maps'
        ]);
        DB::table('settings')->insert([
            'setting_key' => 'home_longitude',
            'setting_value' => '',
            'category' => 'maps'
        ]);        
    }
}
