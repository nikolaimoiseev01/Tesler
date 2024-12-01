<?php

namespace App\Services;

use App\Models\Good\Good;
use Illuminate\Support\Facades\Http;

class GoodYcSale
{
    public function makeGoodSale($good_yc_id, $branch_id, $storage_id, $total_price, $goods_amount): string
    {

        //region Данные для API YClients
        $YCLIENTS_HEADERS = [
            'Accept' => 'application/vnd.yclients.v2+json',
            'Authorization' => 'Bearer ' . ENV('YCLIENTS_BEARER') . ', User ' . ENV('YCLIENTS_ADMIN_TOKEN')
        ];
        //endregion

        //region Создание складской операции
        $url = 'https://api.yclients.com/api/v1/storage_operations/operation/' . $branch_id;
        $cost_per_unit = $total_price / $goods_amount;
        $data = "{
              \"type_id\": 1,
              \"create_date\": \"" . date('Y-m-d H:i:s') . "\",
              \"storage_id\":  $storage_id,
              \"master_id\" : 724514,
              \"goods_transactions\": [
                  {
                    \"document_id\": 123456,
                    \"good_id\": $good_yc_id,
                    \"amount\": $goods_amount,
                    \"cost_per_unit\": $cost_per_unit,
                    \"discount\": 0,
                    \"cost\": $total_price,
                    \"operation_unit_type\": 1,
                    \"master_id\" : 724514
                  }
              ]
        }";

        $new_storage_operation = Http::withHeaders($YCLIENTS_HEADERS)
            ->withBody($data)
            ->post($url)
            ->collect();
        //endregion

        //region Оплата в кассу

        $data_selling = "{
                    \"payment\": {
                        \"method\": {
                            \"slug\": \"account\",
                            \"account_id\": 472965
                        },
                    \"amount\": " . $total_price . "
                    }
                    }";

        $document_id = $new_storage_operation['data']['document_id'];
        $url_selling = 'https://api.yclients.com/api/v1/company/' . $branch_id . '/sale/' . $document_id . '/payment';
        $make_selling = Http::withHeaders($YCLIENTS_HEADERS)
            ->withBody($data_selling)
            ->post($url_selling)
            ->collect();

        $good = Good::whereJsonContains('yc_ids', ['good_id' => $good_yc_id])->first();

        $old_amount = json_decode($good['yc_actual_amount'], true);
        // Ищем нужный элемент и изменяем его
        foreach ($old_amount as &$item) {
            if ($item['branch_id'] === $branch_id && $item['storage_id'] === $storage_id) {
                $item['amount'] = $item['amount'] - $goods_amount;
            }
        }
        $new_amount = json_encode($old_amount);
        $good->update([
            'yc_actual_amount' => $new_amount
        ]);
        //endregion

        return "OK";
    }
}
