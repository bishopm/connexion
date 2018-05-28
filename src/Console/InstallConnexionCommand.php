<?php

namespace Bishopm\Connexion\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Bishopm\Connexion\Models\User;
use Bishopm\Connexion\Models\Household;
use Bishopm\Connexion\Models\Individual;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
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
        if (count($users)) {
            $this->info('This command may only be run on a blank installation. Exiting ...');
        } else {
            $newuser=new User;
            $newhousehold=new Household;
            $newindiv=new Individual;
            $this->info('We will now set up an admin user, who will also be included in the membership database');
            $newindiv->title=$this->choice('What is the title of the admin user?', ['Mr', 'Ms','Mrs']);
            if ($newindiv->title=="Mr") {
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
            $this->call('cache:forget', ['key' => 'spatie.permission.cache']);
            $this->seeder($newuser);
            $this->call('storage:link');
        }
    }

    protected function seeder($newuser)
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
        $p1=Permission::create(['name' => 'admin-backend']);
        $p2=Permission::create(['name' => 'edit-backend']);
        $p3=Permission::create(['name' => 'edit-comments']);
        $p4=Permission::create(['name' => 'view-backend']);
        $p5=Permission::create(['name' => 'admin-giving']);
        $p6=Permission::create(['name' => 'edit-bookshop']);
        $p7=Permission::create(['name' => 'edit-roster']);
        $p8=Permission::create(['name' => 'edit-worship']);
        $p9=Permission::create(['name' => 'view-worship']);
        $role = Role::create(['name' => 'Administrator']);
        $role->givePermissionTo($p1);
        $role->givePermissionTo($p2);
        $role->givePermissionTo($p3);
        $role->givePermissionTo($p4);
        $role->givePermissionTo($p6);
        $role->givePermissionTo($p7);
        $role->givePermissionTo($p8);
        $role->givePermissionTo($p9);
        $role2 = Role::create(['name' => 'User']);
        $role2->givePermissionTo($p3);
        $role3 = Role::create(['name' => 'Bookshop manager']);
        $role3->givePermissionTo($p6);
        $role4 = Role::create(['name' => 'Giving administrator']);
        $role4->givePermissionTo($p5);
        $role5 = Role::create(['name' => 'Roster editor']);
        $role5->givePermissionTo($p7);
        $role6 = Role::create(['name' => 'Manager']);
        $role6->givePermissionTo($p2);
        $role6->givePermissionTo($p3);
        $role6->givePermissionTo($p4);
        $role6->givePermissionTo($p6);
        $role6->givePermissionTo($p7);
        $role6->givePermissionTo($p8);
        $role6->givePermissionTo($p9);
        $role7 = Role::create(['name' => 'Worship team']);
        $role7->givePermissionTo($p4);
        $role7->givePermissionTo($p8);
        $role7->givePermissionTo($p9);
        $role8 = Role::create(['name' => 'Pastoral staff']);
        $role8->givePermissionTo($p2);
        $role8->givePermissionTo($p4);
        $role8->givePermissionTo($p7);
        $newuser->assignRole('Administrator');
    }
}
