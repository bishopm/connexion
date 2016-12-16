<?php

namespace bishopm\base\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use bishopm\base\Models\User;

class InstallConnexionCommand extends Command
{
    protected $signature = 'connexion:install';
    protected $description = 'Initial setup of Connexion Application';

    public function handle()
    {
        $users=User::all();
        if (count($users)){
            $this->info('This command may only be run on a blank installation. Exiting ...');
        } else {
            $newuser=New User;
            $newuser->name=$this->ask('Enter name of administrative user');
            $newuser->email=$this->ask('Enter user email address');
            $newuser->password=Hash::make($this->secret('Enter user password'));
            $this->call('migrate');
            $this->info('Creating new administrative user...');
            $newuser->save();          
        }
    }
}
