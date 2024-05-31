<?php

namespace App\Console\Commands;

use App\Services\ServiceYcOperations;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class ServiceRefresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:service-refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        App::make(ServiceYcOperations::class)->refreshAll();
    }
}
