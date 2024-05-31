<?php

namespace App\Console\Commands;

use App\Services\ServiceYcOperations;
use App\Services\StaffYcOperations;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class StaffRefresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:staff-refresh';

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
        App::make(StaffYcOperations::class)->refreshAll();
    }
}
