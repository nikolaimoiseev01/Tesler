<?php

namespace App\Console\Commands\BigUpgrade;

use App\Models\Service\Category;
use App\Models\Service\Scope;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MakeScopePics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:make-scope-pics';

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

            $scopes = Scope::all();

            foreach ($scopes as $scope) {
                $url = public_path("/" . $scope['pic_main_page']);
                $scope->addMedia($url)->toMediaCollection('main_page_pic');

                $url = public_path("/" . $scope['pic_scope_page']);
                $scope->addMedia($url)->toMediaCollection('scope_page_pic');
            }
        });

        dd('Все закончилось успешно!');
    }
}
