<?php

namespace App\Console\Commands\BigUpgrade;

use App\Models\Service\Category;
use App\Models\Staff;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MakeStaffCollegues extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:make-staff-collegues';

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

            $staffs = Staff::all();

            foreach ($staffs as $staff_m) {
                $option_ids_array = [];
                if ($staff_m['collegues']) {
                    foreach ($staff_m['collegues'] as $staff) {
                        $staff_found = Staff::where('id', $staff['id'])->first();
                        if($staff_found) {
                            $option_ids_array[] = str($staff['id']);
                        }
                    }
                    $staff_m->update(['collegues' => $option_ids_array]);
                }
            }
        });

        dd('Все закончилось успешно!');
    }
}
