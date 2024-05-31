<?php

namespace App\Console\Commands\BigUpgrade;

use App\Models\Service\Category;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MakeCategoryPics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:make-category-pics';

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

            $categories = Category::whereNotNull('pic')->get();

            foreach ($categories as $category) {
                $url = public_path("/" . $category['pic']);
                $category->addMedia($url)->toMediaCollection('main_pic');
            }

            dd('Все закончилось успешно!');
        });
    }
}
