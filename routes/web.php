<?php

use App\Models\User;
use Inertia\Inertia;
use App\Models\Supplier;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\Admin as Admin;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/test', function () {
    
});

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard2', function () {
    return Inertia::render('Dashboard2');
})->middleware(['auth', 'verified'])->name('dashboard2');

Route::middleware(['auth', 'verified'])
    ->as('dashboard.')
    ->group(function () {
        //user management
        Route::group(['middleware' => ['can:view_user']], function () {
            Route::resource('/user', Admin\UserController::class);
        });
        //category
        Route::group(['middleware' => ['can:view_category']], function () {
            Route::resource('/category', Admin\CategoryController::class);
        });
        //item
        Route::group(['middleware' => ['can:view_item']], function () {
            Route::resource('/item', Admin\ItemController::class);
        });
        //mode of payment
        Route::group(['middleware' => ['can:view_mode_of_payment']], function () {
            Route::resource('/mode-of-payment', Admin\ModeOfPaymentController::class);
        });
        //unit
        Route::group(['middleware' => ['can:view_unit']], function () {
            Route::resource('/unit', Admin\UnitController::class);
        });
        //demand
        Route::group(['middleware' => ['can:view_demand']], function () {
            Route::resource('/demand', Admin\DemandController::class);
        });
        //supplier
        Route::group(['middleware' => ['can:view_supplier']], function () {
            Route::resource('/supplier', Admin\SupplierController::class);
        });
        //client
        Route::group(['middleware' => ['can:view_client']], function () {
            Route::resource('/client', Admin\ClientController::class);
        });
        //person
        Route::group(['prefix' => 'company/{company_id}', 'as' => 'company.'], function () {
            Route::group(['middleware' => ['can:view_person']], function () {
                Route::resource('/person', Admin\PersonController::class);
            });
        });
        //tender
        Route::group(['middleware' => ['can:view_tender']], function () {
            Route::resource('/tender', Admin\TenderController::class);
        });
        //quotation
        Route::group(['middleware' => ['can:view_quotation']], function () {
            Route::resource('/quotation', Admin\QuotationController::class);
        });
        //company
        Route::group(['middleware' => ['can:view_company']], function () {
            Route::resource('/company', Admin\CompanyController::class);
        });
});

require __DIR__.'/auth.php';
