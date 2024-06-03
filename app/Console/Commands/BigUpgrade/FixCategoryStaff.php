<?php

namespace App\Console\Commands\BigUpgrade;

use App\Models\Service\Category;
use App\Models\Staff;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixCategoryStaff extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fix-category-staff';

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

            $categories = Category::all();

            foreach ($categories as $category) {
                $option_ids_array = [];
                if ($category['staff_ids']) {
                    foreach ($category['staff_ids'] as $staff) {
                        $staff_found = Staff::where('id', $staff)->first();
                        if($staff_found) {
                            $option_ids_array[] = str($staff);
                        }
                    }
                    $category->update(['staff_ids' => $option_ids_array]);
                }
            }
        });

        dd('Все закончилось успешно!');
    }
}
