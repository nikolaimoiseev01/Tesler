<?php

namespace App\Console\Commands\BigUpgrade;

use App\Models\Calculators\CalcCosmetic;
use App\Models\Service\Category;
use Illuminate\Console\Command;

class MakeCategoryStaff extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:make-category-staff';

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

        $categories = Category::all();

        foreach ($categories as $category) {
            $option_ids_array = [];
            if ($category['staff_ids']) {
                foreach ($category['staff_ids'] as $staff) {
                    $option_ids_array[] = str($staff['id']);
                }
                $category->update(['staff_ids'=>$option_ids_array]);
            }
        }

        dd('Все закончилось успешно!');


    }
}
