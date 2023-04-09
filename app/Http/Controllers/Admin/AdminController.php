<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Good;
use App\Models\Promo;
use App\Models\Service;
use App\Models\ShopSet;
use App\Models\Staff;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function Category_edit(Request $request)
    {
        $category = Category::where('id', $request->category_id)->first();
        return view('admin.service.category.edit', [
            'category' => $category
        ]);
    }

    public function Service_edit(Request $request)
    {
        $service = Service::where('id', $request->service_id)->first();
        return view('admin.service.service.edit', [
            'service' => $service
        ]);
    }

    public function Good_edit(Request $request)
    {
        $good = Good::where('id', $request->good_id)->first();
        return view('admin.good.edit', [
            'good' => $good
        ]);
    }

    public function Shopset_edit(Request $request)
    {
        $shopset = ShopSet::where('id', $request->shopset_id)->first();
        return view('admin.good.shopset_edit', [
            'shopset' => $shopset
        ]);
    }

    public function Staff_edit(Request $request)
    {
        $staff = Staff::where('id', $request->staff_id)->first();
        return view('admin.staff.edit', [
            'staff' => $staff
        ]);
    }
}
