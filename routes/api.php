<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//
//});

# End Users
Route::group(['prefix' => 'user'], function() { # User actions...
    Route::group(['prefix' => 'auth'], function() {
        Route::post('/login', [\App\Http\Controllers\Auth\UserAuthController::class, 'login']);
        Route::post('/register', [\App\Http\Controllers\Auth\UserAuthController::class, 'register']);
        Route::post('/logout', [\App\Http\Controllers\Auth\UserAuthController::class, 'logout'])->middleware('auth:api');
        Route::get('profile', [\App\Http\Controllers\UsersController::class, 'profile'])->middleware('auth:api');
    });


    Route::group(['middleware' => ['auth:api']], function(){
        // Items
        Route::group(['prefix' => 'item'], function() {
            Route::get('', [\App\Http\Controllers\ItemsController::class, 'index'])->name('user.item.index');
            Route::get('{item}', [\App\Http\Controllers\ItemsController::class, 'show'])->name('user.item.show');
        });

        Route::group(['prefix' => 'order'], function() {
            Route::get('', [\App\Http\Controllers\Orders\OrdersController::class, 'index'])->name('user.item.index');
            Route::get('{order}', [\App\Http\Controllers\Orders\OrdersController::class, 'show'])->name('user.item.show');
            Route::post('', [\App\Http\Controllers\Orders\OrdersController::class, 'create'])->name('user.item.create');

            Route::post('payment', [\App\Http\Controllers\PaymentsController::class, 'payForOrder']);
        });
    });

});

# Administrators
Route::group(['prefix' => 'admin'], function() {
    // Profile Auths
    Route::group(['prefix' => 'auth'], function() {
        Route::post('login', [\App\Http\Controllers\Admin\Auth\AuthenticationsController::class, 'login']);
        Route::post('logout', [\App\Http\Controllers\Admin\Auth\AuthenticationsController::class, 'logout'])->middleware('auth.admin_api');
        Route::get('profile', [\App\Http\Controllers\Admin\AdministratorsController::class, 'profile'])->middleware('auth.admin_api');
    });

    // Items
    Route::group(['middleware' => ['auth.admin_api', 'is_active']], function() {
        Route::group(['prefix' => 'item'], function(){
            Route::get('', [\App\Http\Controllers\Admin\Items\ItemsController::class, 'index'])->name('admin.item.index');
            Route::post('', [\App\Http\Controllers\Admin\Items\ItemsController::class, 'create'])->name('admin.item.create');
            Route::get('{item}', [\App\Http\Controllers\Admin\Items\ItemsController::class, 'show'])->name('admin.item.show');
            Route::put('{item}', [\App\Http\Controllers\Admin\Items\ItemsController::class, 'update'])->name('admin.item.update');
            Route::patch('{item}/restock', [\App\Http\Controllers\Admin\Items\ItemsController::class, 'restock'])->name('admin.item.restock');
        });
    });


});
