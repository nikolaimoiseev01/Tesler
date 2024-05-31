<?php

namespace App\Console\Commands\BigUpgrade;

use App\Models\Calculators\CalcCosmetic;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MakeCalcCosmeticOptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:make-calc-cosmetic-options';

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

        DB::transaction(function () { // Чтобы не записать ненужного
            $options = CalcCosmetic::all();

            foreach ($options as $option) {
                $option_ids_array = [];
                if ($option['services']) {
                    foreach ($option['services'] as $service) {
                        $option_ids_array[] = str($service['id']);
                    }
                    $option->update(['services' => $option_ids_array]);

                }
            }
        });

        dd('Все закончилось успешно!');

    }
}
