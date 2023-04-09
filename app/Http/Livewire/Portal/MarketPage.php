<?php

namespace App\Http\Livewire\Portal;

use App\Models\Good;
use App\Models\GoodCategory;
use App\Models\ShopSet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;

class MarketPage extends Component
{
    public $abon_page_check;

    public $goods;
    public $goods_amt = 10;
    public $price_min;
    public $price_max;
    public $categories;
    public $yc_category = [];
    public $goods_orig;
    public $search_input;
    public $sort_type;
    public $shopset = [];
    public $shopsets;
    public $hair_types;
    public $hair_type = [];
    public $skin_types;
    public $skin_type = [];

    public $price_all_max;

    public $load_more_check;

    protected $listeners = ['refreshMarketPage' => '$refresh', 'make_sorting'];
    protected $queryString = ['price_min', 'price_max', 'yc_category', 'search_input', 'shopset', 'hair_type', 'skin_type'];

    public function render()
    {


        $this->goods = $this->goods_orig->where('yc_price', '>', 0)
            ->where('yc_price', '>', intval($this->price_min ?? 0))
            ->where('yc_price', '<', intval($this->price_max ?? 999999999))
//            ->when($this->yc_category, function ($q) {
//                return $q->whereIn('yc_category', $this->yc_category);
//            })
            ->when($this->yc_category,function ($item) {
                return $item->filter(function($q) {

                    if ($q['good_category_id']) {
                        foreach ($this->yc_category as $yc_category) {
                            if(array_search($yc_category, $q['good_category_id']) !== null & array_search($yc_category, $q['good_category_id']) !== false) {
                                return $q;
                            }
                        }

                    }
                });
            })
            ->when($this->skin_type, function ($q) {
                return $q->whereIn('skin_type', $this->skin_type);
            })
            ->when($this->hair_type, function ($q) {
                return $q->whereIn('hair_type', $this->hair_type);
            })
            ->when($this->sort_type == 'price_asc', function ($q) {
                return $q->sortBy('yc_price');
            })
            ->when($this->sort_type == 'price_desc', function ($q) {
                return $q->sortByDesc('yc_price');
            })
            ->filter(function ($item) {
                $search = mb_strtolower($this->search_input);
                return preg_match("/$search/",mb_strtolower($item['name']));
            })
            ->when($this->shopset,function ($item) {
                return $item->filter(function($q) {

                    if ($q['in_shopsets']) {
                        foreach ($this->shopset as $shopset) {
                            if(array_search($shopset, $q['in_shopsets']) !== null & array_search($shopset, $q['in_shopsets']) !== false) {
                                return $q;
                            }
                        }

                    }
                });
            });

        $goods_count_before_take = count($this->goods);

        $this->goods = $this->goods->take($this->goods_amt);

        $goods_count_after_take = count($this->goods);

        if($goods_count_before_take > $goods_count_after_take) {
            $this->load_more_check = true;
        } else {
            $this->load_more_check = false;
        }

        return view('livewire.portal.market-page');
    }

//    public function dehydrate()
//    {
//        $this->emit('refreshMarketPage');
//    }

    public function mount($goods, $categories, $abon_page_check)
    {
        $this->abon_page_check = $abon_page_check;

        $this->goods_orig = $goods;
        $this->categories = $categories;
        $this->price_all_max = $goods->max('yc_price');
        $this->goods = $this->goods_orig->take($this->goods_amt);
        $this->shopsets = ShopSet::orderBy('title')->get();
        $this->skin_types = $this->goods_orig->where('skin_type', '<>', null)->unique('skin_type')->pluck('skin_type');
        $this->hair_types = $this->goods_orig->where('hair_type', '<>', null)->unique('hair_type')->pluck('hair_type');

    }

    public function make_sorting($sort_type)
    {
        $this->sort_type = $sort_type;
    }

    public function load_more()
    {
        $this->goods_amt += 10;
        $this->emit('refreshMarketPage');
    }
}
