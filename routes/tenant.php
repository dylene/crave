<?php

declare(strict_types=1);

use App\Http\Controllers\AdminTenantUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TenantAuthController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\TenantProductController;
use App\Http\Controllers\TenantUserController;
use App\Http\Middleware\EnsureTenantIsAuthenticated;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
    EnsureTenantIsAuthenticated::class
])->name('tenant.')->group(function () {
    Route::get('/dashboard', [TenantAuthController::class,'dashboard'])->name('dashboard');

    // my account
    Route::get('/my-account', [TenantController::class,'myaccount'])->name('my-account');
    
    // users
    Route::resource('/users', TenantUserController::class);

    // products
    Route::resource('/products', TenantProductController::class);

    // subscriptions
    Route::get('/subscriptions', [TenantController::class,'subscription'])->name('subscription');
    Route::get('/subscriptions/{tenant}', [TenantController::class,'upgradeForm'])->name('subscription.upgrade.form');
    Route::post('/subscriptions/{tenant}', [TenantController::class,'upgrade'])->name('subscription.upgrade');
    
    // logout
    Route::post('/logout', [TenantAuthController::class,'logout'])->name('logout');
});
