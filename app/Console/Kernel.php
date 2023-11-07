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
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('UpdateGoods')->timezone('Europe/Moscow')->dailyAt('13:30');
        $schedule->command('ServiceUpdate')->timezone('Europe/Moscow')->dailyAt('13:30');
        $schedule->command('StuffUpdate')->timezone('Europe/Moscow')->dailyAt('13:30');
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
