<?php

namespace App\Services;

use App\Models\Service\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class YcApiRequest
{
    public function make_request($url_type, $url_end)
    {
        $YCLIENTS_SHOP_ID = ENV('YCLIENTS_SHOP_ID');
        $YCLIENTS_HEADERS = [
            'Accept' => 'application/vnd.yclients.v2+json',
            'Authorization' => 'Bearer ' . ENV('YCLIENTS_BEARER') . ', User ' . ENV('YCLIENTS_ADMIN_TOKEN')
        ];

        $url = "https://api.yclients.com/api/v1/{$url_type}/" . ENV('YCLIENTS_SHOP_ID') . "/{$url_end}";

        $yc_response = Http::withHeaders($YCLIENTS_HEADERS)
            ->get($url)
            ->collect();

        $response = $yc_response['data'] ?? $yc_response;
        return $response;
    }
}
