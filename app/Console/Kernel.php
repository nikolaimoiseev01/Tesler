<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected $commands = [
    ];

    /**
     * Define the participation's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('app:good-refresh')->timezone('Europe/Moscow')->dailyAt('21:00');
        $schedule->command('app:staff-refresh')->timezone('Europe/Moscow')->dailyAt('21:15');
        $schedule->command('app:service-refresh')->timezone('Europe/Moscow')->dailyAt('21:30');
    }

    /**
     * Register the commands for the participation.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
