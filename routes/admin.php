<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminTenantController;
use App\Http\Controllers\AdminTenantUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SubscriptionController;
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

Route::prefix('/admin')->name('admin.')->group(function() {

    // unauthenticated admin routes
    Route::middleware('guest:admin')->group(function() {
        Route::get('/login', [AdminController::class,'loginForm'])->name('login.form');
        Route::post('/login', [AdminController::class,'login'])->name('login');
    });

    // authenticated admin routes
    Route::middleware('auth:admin')->group(function() {
        Route::get('/dashboard', [AdminController::class,'dashboard'])->name('dashboard');
        Route::post('/logout', [AdminController::class,'logout'])->name('logout');

        // tenants
        Route::resource('/tenants', AdminTenantController::class);
        // subscriptions
        Route::resource('/subscriptions', SubscriptionController::class);
        // subscriptions
        Route::resource('/tenants/{tenant}/users', AdminTenantUserController::class);
        // products
        Route::resource('/tenants/{tenant}/products', ProductController::class);
    });
});