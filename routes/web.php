<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Auth::routes();

Route::match(['POST'], '/payments/callback', [App\Http\Controllers\Portal\PortalController::class, 'payment_callback'])->name('payment.callback');


Route::get('/', [App\Http\Controllers\Portal\PortalController::class, 'index'])->name('home');

Route::get('/scope/{scope_id}', [App\Http\Controllers\Portal\PortalController::class, 'scope_page'])->name('scope_page');
Route::get('/service/{service_id}', [App\Http\Controllers\Portal\PortalController::class, 'service_page'])->name('service_page');
Route::get('/market/', [App\Http\Controllers\Portal\PortalController::class, 'market_page'])->name('market_page');
Route::get('/market/{good_id}', [App\Http\Controllers\Portal\PortalController::class, 'good_page'])->name('good_page');
Route::get('/market/good_category/{goodcategory_id}', [App\Http\Controllers\Portal\PortalController::class, 'good_category_page'])->name('good_category_page');
Route::get('/abonements/', [App\Http\Controllers\Portal\PortalController::class, 'abonements_page'])->name('abonements_page');
Route::get('/loyalty/', [App\Http\Controllers\Portal\PortalController::class, 'loyalty_page'])->name('loyalty_page');

Route::get('/staff/{staff_yc_id}', [App\Http\Controllers\Portal\PortalController::class, 'staff_page'])->name('staff_page');

Route::get('/courses/{course_id}', [App\Http\Controllers\Portal\PortalController::class, 'course_page'])->name('course_page');


Route::post('temp-uploads/{file_source}', [\App\Http\Controllers\UploadController::class, 'store']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);

Route::get('/orders/{tinkoff_order_id}', [App\Http\Controllers\Portal\PortalController::class, 'order_success_page'])->name('order_success_page');


// ---------  Панель Админа --------- //
Route::prefix('admin_panel')
    ->middleware(['middleware' => 'auth'])
    ->group(function () {
        Route::get('/promo', function () {
            return view('admin.promo.index');
        })->name('promo.index');
        Route::get('/promo/{promo_id}', [App\Http\Controllers\Admin\AdminController::class, 'Promo_edit'])->name('promo.edit');

        Route::get('/iterior_photo', function () {
            return view('admin.iterior_photo.index');
        })->name('iterior_photo.index');

        Route::get('/scopes', function () {
            return view('admin.service.scope.index');
        })->name('scope.index');

        Route::get('/categories', function () {
            return view('admin.service.category.index');
        })->name('category.index');


        Route::get('/categories/create', function () {
            return view('admin.service.category.create');
        })->name('category.create');

        Route::get('/groups', function () {
            return view('admin.service.group.index');
        })->name('group.index');

        Route::get('/services', function () {
            return view('admin.service.service.index');
        })->name('service.index');

        Route::get('/goods', function () {
            return view('admin.good.index');
        })->name('good.index');

        Route::get('/shopsets', function () {
            return view('admin.good.shopset_index');
        })->name('shopset.index');

        Route::get('/calc_cosmetic', function () {
            return view('admin.calc_cosmetic');
        })->name('calc_cosmetic.index');

        Route::get('/calc_hair', function () {
            return view('admin.calc_hair');
        })->name('calc_hair.index');

        Route::get('/staff', function () {
            return view('admin.staff.index');
        })->name('staff.index');

        Route::get('/good_categories', function () {
            return view('admin.good.good_category_index');
        })->name('good_category.index');

        Route::get('/consultations', function () {
            return view('admin.consultation');
        })->name('consultationy.index');

        Route::get('/course_apps', function () {
            return view('admin.course_apps');
        })->name('course_apps.index');

        Route::get('/orders', function () {
            return view('admin.order.order-index');
        })->name('order.index');

        Route::get('/promocodes', function () {
            return view('admin.promocodes-index');
        })->name('promocodes.index');

        Route::get('/courses', [App\Http\Controllers\Admin\AdminController::class, 'Course_index'])->name('course.index');
        Route::get('/courses/{course_id}', [App\Http\Controllers\Admin\AdminController::class, 'Course_edit'])->name('course.edit');

        Route::get('/services/{service_id}', [App\Http\Controllers\Admin\AdminController::class, 'Service_edit'])->name('service.edit');
        Route::get('/categories/{category_id}', [App\Http\Controllers\Admin\AdminController::class, 'Category_edit'])->name('category.edit');
        Route::get('/shopsets/{shopset_id}', [App\Http\Controllers\Admin\AdminController::class, 'Shopset_edit'])->name('shopset.edit');
        Route::get('/staff/{staff_id}', [App\Http\Controllers\Admin\AdminController::class, 'Staff_edit'])->name('staff.edit');
        Route::get('/orders/{order_id}', [App\Http\Controllers\Admin\AdminController::class, 'Order_edit'])->name('order.edit');

        Route::get('/goods/{good_id}', [App\Http\Controllers\Admin\AdminController::class, 'Good_edit'])->name('good.edit');


    });
