<?php

namespace App\Console\Commands\BigUpgrade;

use App\Models\Good\Good;
use App\Models\Good\ShopSet;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MakeShopsetGoods extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:make-shopset-goods';

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

            $goods = Good::whereNotNull('in_shopsets')->get();
            foreach ($goods as $good) {
                foreach ($good['in_shopsets'] as $shopset_id) {
                    $shopset = ShopSet::where('id', $shopset_id)->first();
                    $goods_in_shopset = $shopset['goods'] ?? [];
                    array_push($goods_in_shopset, $good['id']);
                    $shopset->update([
                        'goods' => $goods_in_shopset
                    ]);
                }
            }
            dd('Все закончилось успешно!');
        });
    }
}
