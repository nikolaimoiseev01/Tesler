<?php

namespace App\Services;

use App\Models\Service\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class YcApiRequest
{
    public function make_request($url_type, $url_end, $shop = null)
    {
        $shop = $shop ?? config('cons.yc_shops')[0]; /* Если не прислали филиал, смотрим на первый */

        $YCLIENTS_HEADERS = [
            'Accept' => 'application/vnd.yclients.v2+json',
            'Authorization' => 'Bearer ' . ENV('YCLIENTS_BEARER') . ', User ' . ENV('YCLIENTS_ADMIN_TOKEN')
        ];

        $url = "https://api.yclients.com/api/v1/{$url_type}/{$shop['id']}/{$url_end}";

        $yc_response = Http::withHeaders($YCLIENTS_HEADERS)
            ->get($url)
            ->collect();

        $response = $yc_response['data'] ?? $yc_response;
        return $response;
    }


}
