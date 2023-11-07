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
        Commands\UpdateGoods::class,
    ];


    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('UpdateGoods')->timezone('Europe/Moscow')->dailyAt('13:30');
        $schedule->command('ServiceUpdate')->timezone('Europe/Moscow')->dailyAt('13:30');
        $schedule->command('StuffUpdate')->timezone('Europe/Moscow')->dailyAt('13:30');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
