<?php

use App\Models\User;
use Inertia\Inertia;
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
    $pass = Hash::check('12345678', User::first()->password);
    dd($pass, User::first()->password);
});

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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
});

require __DIR__.'/auth.php';
