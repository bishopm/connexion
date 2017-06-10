<?php

namespace Bishopm\Connexion\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use Bishopm\Connexion\Console\BirthdayEmail;

class ScheduleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->command('BirthdayEmail')->weekly()->saturdays()->at('21:30');
        });
    }

    public function register()
    {
    }
}