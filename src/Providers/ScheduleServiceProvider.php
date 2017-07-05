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
            $schedule->command('connexion:supplieremails')->monthlyOn(1,'07:15');
            $schedule->command('connexion:bookshopemails')->monthlyOn(1,'07:30');
            $schedule->command('connexion:givingemails')->dailyAt('07:45');
            $schedule->command('connexion:birthdayemail')->weekly()->mondays()->at('08:00');            
        });
    }

    public function register()
    {
    }
}