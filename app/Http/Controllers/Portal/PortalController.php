<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Good;
use App\Models\GoodCategory;
use App\Models\interior_photo;
use App\Models\Order;
use App\Models\Promo;
use App\Models\Scope;
use App\Models\Service;
use App\Models\ServiceAdds;
use App\Models\ShopSet;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PortalController extends Controller
{
    public function index()
    {

        $YCLIENTS_SHOP_ID = ENV('YCLIENTS_SHOP_ID');
        $YCLIENTS_HEADERS = [
            'Accept' => 'application/vnd.yclients.v2+json',
            'Authorization' => 'Bearer ' . ENV('YCLIENTS_BEARER') . ', User ' . ENV('YCLIENTS_ADMIN_TOKEN')
        ];


        $admins = Http::withHeaders($YCLIENTS_HEADERS)
            ->get('https://api.yclients.com/api/v1/company/' . $YCLIENTS_SHOP_ID . '/staff/')
            ->collect();

        $admins = Arr::where($admins['data'], function ($value, $key) {
            if ($value['position']) {
                return $value['position']['title'] == 'Администратор';
            }
        });

        $admins = Arr::where($admins, function ($value, $key) {
            if ($value['position']) {
                return $value['fired'] == 0;
            }
        });

        $admins = array_slice($admins, 0, 4);

        $promos = Promo::orderBy('position')->get();
        $interior_pics = interior_photo::orderBy('position')->pluck('pic')->all();
        $scopes = Scope::orderBy('position')->with('group')->get();

        $shopsets_pre = ShopSet::orderBy('title')->take(3)->get();


        foreach ($shopsets_pre as $shopset) {
            $full_price = Good::whereJsonContains('in_shopsets', $shopset['id'])
                ->sum('yc_price');
            $shopsets[] = [
                'id' => $shopset['id'],
                'title' => $shopset['title'],
                'price' => $full_price,
                'img' => $shopset->getFirstMediaUrl('pic_shopset'),
                'link' => route('market_page') . '?shopset[0]=' . $shopset['id'],
                'category' => 'SHOP-СЕТ'
            ];
        }


        return view('portal.index', [
            'promos' => $promos,
            'interior_pics' => $interior_pics,
            'admins' => $admins,
            'scopes' => $scopes,
            'shopsets' => $shopsets
        ]);

    }

    public function scope_page(Request $request)
    {
        $YCLIENTS_SHOP_ID = ENV('YCLIENTS_SHOP_ID');
        $YCLIENTS_HEADERS = [
            'Accept' => 'application/vnd.yclients.v2+json',
            'Authorization' => 'Bearer ' . ENV('YCLIENTS_BEARER') . ', User ' . ENV('YCLIENTS_ADMIN_TOKEN')
        ];

        $scope = Scope::where('id', $request->scope_id)->with('category')->first();

        $category_staff_pre[] = [];
        foreach ($scope->category as $category) {
            $category_counter = 0;
            foreach ($category->group as $key => $group) {

                for ($x = 0; $x <= 4; $x++) {
                    $category_check = Arr::where($category_staff_pre, function ($value, $key) use ($category) {
                        if (($value['category_id'] ?? null)) {
                            return $value['category_id'] == $category['id'];
                        }
                    });


                    if (!($group->service[$x] ?? null) || count($category_check) > 4) // Если не можем найти услугу, нужно выходить из цикла
                    {
                        break;
                    };
                    $yc_service = Http::withHeaders($YCLIENTS_HEADERS)
                        ->get('https://api.yclients.com/api/v1/company/' . $YCLIENTS_SHOP_ID . '/services/' . $group->service[$x]['yc_id'])
                        ->collect();
                    foreach ($yc_service['data']['staff'] as $staff) {
                        $category_staff_pre[] = [
                            'category_id' => $category['id'],
                            'staff_id' => $staff['id'],
                            'image_url' => $staff['image_url'],
                            'name' => $staff['name'],
                        ];

                    }
                }


            }
        }


        // Удаляем дубликаты в работниках
        foreach ($category_staff_pre as $k => $v) {
            $category_staff[implode($v)] = $v;
        }
        $category_staff = array_values($category_staff);

        unset($category_staff[0]);
//        dd($category_staff);

        return view('portal.scope_page', [
            'scope' => $scope,
            'category_staff' => $category_staff
        ]);
    }

    public function service_page(Request $request)
    {
        $YCLIENTS_SHOP_ID = ENV('YCLIENTS_SHOP_ID');
        $YCLIENTS_HEADERS = [
            'Accept' => 'application/vnd.yclients.v2+json',
            'Authorization' => 'Bearer ' . ENV('YCLIENTS_BEARER') . ', User ' . ENV('YCLIENTS_ADMIN_TOKEN')
        ];

//        dd($request->service_id);

        $service = Service::where('id', intval($request->service_id))->first();
//        dd($service);
        $service_id = $service['id'];
        $service_add = Service::whereIn('id', function ($query) use ($service_id) {
            $query->select('service_add')
                ->from(with(new ServiceAdds)->getTable())
                ->whereIn('to_service', [$service_id]);
        })->get();

        $workers = Http::withHeaders($YCLIENTS_HEADERS)
            ->get('https://api.yclients.com/api/v1/company/' . $YCLIENTS_SHOP_ID . '/staff/')
            ->collect()['data'];


        $workers = array_values(Arr::where($workers, function ($value, $key) {
            return $value['fired'] == 0;
        })); // Только неуволенных сотрудников

        $yc_service = Http::withHeaders($YCLIENTS_HEADERS)
            ->get('https://api.yclients.com/api/v1/company/' . $YCLIENTS_SHOP_ID . '/services/' . $service['yc_id'])
            ->collect()['data'];
//        dd($service['yc_id']);

        $yc_service = Http::withHeaders($YCLIENTS_HEADERS)
            ->get('https://api.yclients.com/api/v1/company/' . $YCLIENTS_SHOP_ID . '/services/' . $service['yc_id'])
            ->collect()['data']['staff'];
//        dd($yc_service);



        foreach ($yc_service as $arr) {
            $options[] = current($arr);  // COnverted to 1-d array
        }



        /* Filter $array2 and obtain those results for which ['ASIN'] value matches with one of the values contained in $options */
        if ($options ?? null !== null) {
            $service_workers = array_filter($workers, function ($v) use ($options) {
                return in_array($v['id'], $options);
            });
            $service_workers = array_slice($service_workers, 0, 4);
        }



        $abonements_pre = Good::where('yc_category', 'Абонементы Сеть Tesler')->where('category_id', $service['category_id'])->take(3)->get();
//dd($abonements_pre);
        foreach ($abonements_pre as $abonement) {
            $abonements[] = [
                'id' => $abonement['id'],
                'title' => $abonement['name'],
                'price' => $abonement['yc_price'],
                'img' => $abonement->getFirstMediaUrl('good_examples'),
                'link' => route('good_page', $abonement['id']),
                'category' => 'Абонемент'
            ];
        }

        $abonements = isset($abonements) ? $abonements : null;
//        dd($service_workers);
        return view('portal.service_page', [
            'service' => $service,
            'service_add' => $service_add,
            'service_workers' => $service_workers ?? null,
            'abonements' => $abonements
        ]);
    }

    public function market_page(Request $request)
    {

        $goods = Good::where('yc_price', '>', 0)
            ->whereJsonDoesntContain('good_category_id', 6)
            ->whereJsonDoesntContain('good_category_id', 7)
            ->where('flg_active', 1)
            ->get();


        $goods_with_categories = [];
        foreach ($goods as $good) {
            foreach ($good['good_category_id'] as $category_id) {
                array_push($goods_with_categories, $category_id);
            }
        }


        $categories = GoodCategory::whereIn('id', $goods_with_categories)
            ->get();

        $abon_page_check = false;

        return view('portal.market_page', [
            'goods' => $goods,
            'categories' => $categories,
            'abon_page_check' => $abon_page_check
        ]);
    }

    public function good_page($good_id)
    {
        $good = Good::where('id', $good_id)->first();

        return view('portal.good_page', [
            'good' => $good,
        ]);
    }

    public function abonements_page()
    {
        $goods = Good::where('yc_price', '>', 0)
            ->where('yc_category', 'Абонементы Сеть Tesler')
            ->orWhere('yc_category', 'Сертификаты Сеть Tesler')
            ->get();

        $categories = GoodCategory::whereIn('id', [6, 7])->get();

        $abon_page_check = true;

        return view('portal.abonements_page', [
            'goods' => $goods,
            'categories' => $categories,
            'abon_page_check' => $abon_page_check
        ]);
    }

    public function loyalty_page()
    {
        $abonements_pre = Good::where('yc_category', 'Абонементы Сеть Tesler')->take(3)->get();


        foreach ($abonements_pre as $abonement) {

            $abonements[] = [
                'id' => $abonement['id'],
                'title' => $abonement['name'],
                'price' => $abonement['yc_price'],
                'img' => $abonement->getFirstMediaUrl('good_examples'),
                'link' => route('good_page', $abonement['id']),
                'category' => 'Абонемент'
            ];
        }

        $interior_pics = interior_photo::orderBy('position')->pluck('pic')->all();
        return view('portal.loyalty_page', [
            'interior_pics' => $interior_pics,
            'abonements' => $abonements
        ]);
    }

    public function staff_page(Request $request)
    {

        $staff = Staff::where('yc_id', $request->staff_yc_id)->first();
        $shopsets_pre = ShopSet::where('staff_id', $staff['id'])->get();

        $selected_from_staff = null;

        // Шопсет сотрудника
        $shopset = ShopSet::where('id', $staff['selected_shopset'])->first();
        if ($shopset ?? null && count($shopset) > 0) {
            $full_price = Good::whereJsonContains('in_shopsets', $shopset['id'])
                ->sum('yc_price');
            $selected_from_staff[] = [
                'id' => $shopset['id'],
                'title' => $shopset['title'],
                'price' => $full_price,
                'img' => $shopset->getFirstMediaUrl('pic_shopset'),
                'link' => route('market_page') . '?shopset[0]=' . $shopset['id'],
                'category' => 'SHOP-СЕТ'
            ];
        }


        // Сертификат сотрудника
        $good = Good::where('id', $staff['selected_sert'])->first();
        if ($good ?? null && count($good) > 0) {
            $selected_from_staff[] = [
                'id' => $good['id'],
                'title' => $good['name'],
                'price' => $good['yc_price'],
                'img' => $shopset->getFirstMediaUrl('good_examples'),
                'link' => route('good_page', $good['id']),
                'category' => 'Сертификат'
            ];
        }

        // Абонемент сотрудника
        $good = Good::where('id', $staff['selected_abon'])->first();
        if ($good ?? null && count($good) > 0) {
            $selected_from_staff[] = [
                'id' => $good['id'],
                'title' => $good['name'],
                'price' => $good['yc_price'],
                'img' => $shopset->getFirstMediaUrl('good_examples'),
                'link' => route('good_page', $good['id']),
                'category' => 'Абонемент'
            ];
        }


//        dd($shopsets);
        return view('portal.staff_page', [
            'staff' => $staff,
            'selected_from_staff' => $selected_from_staff ?? null
        ]);
    }

    public function good_category_page(Request $request)
    {


        $goods_all = Good::where('yc_price', '>', 0)
            ->whereJsonDoesntContain('good_category_id', 6)
            ->whereJsonDoesntContain('good_category_id', 7)
            ->where('flg_active', 1)
            ->get();

        $goods_with_categories = [];
        foreach ($goods_all as $good) {
            foreach ($good['good_category_id'] as $category_id) {
                array_push($goods_with_categories, $category_id);
            }
        }
        $categories = GoodCategory::whereIn('id', $goods_with_categories)
            ->get();

        $goods = Good::where('yc_price', '>', 0)
            ->whereJsonContains('good_category_id', intval($request->goodcategory_id))
            ->where('flg_active', 1)
            ->get();


        $abon_page_check = false;

        $goodcategory = GoodCategory::where('id', $request->goodcategory_id)->first();
        return view('portal.good_category_page', [
            'goods' => $goods,
            'categories' => $categories,
            'goodcategory' => $goodcategory,
            'abon_page_check' => $abon_page_check
        ]);

    }


    public function payment_callback(Request $request)
    {

        Log::info('//////////////////////////  CALBACK STARTED //////////////////////////');
        Log::info('//  $request STARTED //');
        Log::info($request['Status']);
        Log::info($request);
        Log::info($request['Status'] == 'CONFIRMED');
        Log::info('// $request ENDED //');


        if ($request['Status'] === 'CONFIRMED') {
            $status = 'Подтвержден';
        } else if ($request['Status'] === 'REJECTED') {
            $status = 'Отклонен';
        } else if ($request['Status'] === 'REFUNDED') {
            $status = 'Возвращен';
        }

        Order::where('tinkoff_order_id', $request['OrderId'])->update([
            'tinkoff_status' => $status,
        ]);


//    $requestBody = json_decode($source, true);
//    Log::info('//  $requestBody STARTED //');
//    Log::info($requestBody);
//    Log::info('// $requestBody ENDED //');
//
//    $notification = $requestBody['object'];
//    Log::info('//  $notification STARTED //');
//    Log::info($notification);
//    Log::info('// $notification ENDED //');
    }

    public function order_success_page($tinkoff_order_id) {
        $order = Order::where('tinkoff_order_id', $tinkoff_order_id)->first();
        return view('portal.order_success_page', [
            'order' => $order,
        ]);
    }

}
