<?php

namespace App\Console\Commands\BigUpgrade;

use App\Models\Service\Service;
use App\Models\ServiceAdds;
use Illuminate\Console\Command;

class MakeServiceAdds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:make-service-adds';

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
        $service_adds_orig = ServiceAdds::where('to_service', 32)->get();

        foreach ($service_adds_orig as $service_add) {
            $service_to = Service::where('id', $service_add['to_service'])->first();
            if($service_to) {
                $service_adds = $service_to['service_adds'] ?? [];
                array_push($service_adds, $service_add['service_add']);
                $service_to->update([
                    'service_adds' => $service_adds
                ]);
            }
        }

        dd('Все закончилось успешно!');

    }
}
