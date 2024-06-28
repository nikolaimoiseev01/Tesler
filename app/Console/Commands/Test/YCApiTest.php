<?php

namespace App\Console\Commands\Test;

use App\Models\Service\Service;
use App\Services\ServiceYcOperations;
use App\Services\YcApiRequest;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class YCApiTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'yc_api_test';

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
        $service = Service::where('id', 472)->first();

        $shop = config('cons.yc_shops')[0];

        $service_api_data = (new YcApiRequest)->make_request('company', "services/{$service['yc_id']}", $shop);
    }
}
