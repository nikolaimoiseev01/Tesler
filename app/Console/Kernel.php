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
<<<<<<< HEAD
        $schedule->command('app:update-goods')->timezone('Europe/Moscow')->dailyAt('15:07');
=======
        $schedule->command('UpdateGoods')->timezone('Europe/Moscow')->dailyAt('13:30');
<<<<<<< HEAD
        $schedule->command('UpdateService')->timezone('Europe/Moscow')->dailyAt('13:30');
        $schedule->command('UpdateStaff')->timezone('Europe/Moscow')->dailyAt('13:30');
=======
        $schedule->command('ServiceUpdate')->timezone('Europe/Moscow')->dailyAt('13:30');
        $schedule->command('StuffUpdate')->timezone('Europe/Moscow')->dailyAt('13:30');
>>>>>>> e3f482b26747b7b3b18e3b2bace1afd202ad8e79
>>>>>>> e0f7e9c111a7dc9488c1a2a834cfba24860dfdb2
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
