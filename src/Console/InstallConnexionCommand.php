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
            $this->call('vendor:publish');
        }
    }

    protected function seeder()
    {
        /*DB::table('roles')->insert([
            'name' => 'admin',
            'display_name' => 'Administrator',
            'description' => 'Site administrator with full access to all functions'
        ]);
        DB::table('roles')->insert([
            'name' => 'editor',
            'display_name' => 'Editor',
            'description' => 'Site editor with ability to change data, but not access administrative functions'
        ]);
        DB::table('roles')->insert([
            'name' => 'backend',
            'display_name' => 'Backend',
            'description' => 'Backend user with limited powers to change data and no administrative rights'
        ]);
        DB::table('permissions')->insert([
            'name' => 'adminminister-site',
            'display_name' => 'Administer site',
            'description' => 'Use administration functions'
        ]);
        DB::table('permissions')->insert([
            'name' => 'read-content',
            'display_name' => 'Read content',
            'description' => 'View non-administrative content'
        ]);
        DB::table('permissions')->insert([
            'name' => 'edit-content',
            'display_name' => 'Edit content',
            'description' => 'Edit non-administrative content'
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
            'role_id' => '2',
            'permission_id' => '2'
        ]);
        DB::table('permission_role')->insert([
            'role_id' => '2',
            'permission_id' => '3'
        ]);
        DB::table('permission_role')->insert([
            'role_id' => '3',
            'permission_id' => '3'
        ]);
        DB::table('role_user')->insert([
            'role_id' => '1',
            'user_id' => '1'
        ]);*/
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
