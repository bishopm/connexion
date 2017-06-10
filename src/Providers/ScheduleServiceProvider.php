<?php

namespace Bishopm\Connexion\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;

class ScheduleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->command('connexion:birthdayemail')->weekly()->mondays()->at('08:00');
        });
    }

    public function register()
    {
    }
}