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
        $this->call('vendor:publish', ['--all' => true]);
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
    }
}
