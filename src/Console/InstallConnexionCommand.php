<?php

namespace bishopm\base\Console;

use Illuminate\Console\Command;
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
            $this->ask('Enter name of administrative user');
            $this->ask('Enter user email address');
            $this->secret('Enter user password');
            $this->info('Creating new administrative user...');
        }
    }
}
