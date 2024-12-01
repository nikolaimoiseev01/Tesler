<?php

namespace App\Console\Commands\Test;

use App\Models\Good\Good;
use App\Models\RefreshLog;
use App\Notifications\TelegramNotification;
use App\Services\GoodYcSale;
use App\services\YcApiRequest;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

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
//        $good_yc_id = 25562546; // Тестовый товар на Авиаторов
//        $branch_id = 247576; // Филиал авиаторов
//        $storage_id = 1039381; // Склад "НУЛИК склад- НЕ ИСПОЛЬЗОВАТЬ!!!" на Авиаторов

        $good_yc_id = 34827697; // Тестовый товар на Бограда
        $branch_id = 921995; // Филиал бограда
        $storage_id = 2174746; // Склад "ТЕСТ для сайта БОГРАДА" на Бограда

        $total_price = 1;
        $goods_amount = 1;

        App::make(GoodYcSale::class)->makeGoodSale($good_yc_id, $branch_id, $storage_id, $total_price, $goods_amount);

    }
}
