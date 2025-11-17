<?php

use App\Http\Middleware\CheckAuth;
use App\Livewire\Auth\Login;
use App\Livewire\Category\CreateCategory;
use App\Livewire\Category\EditCategory;
use App\Livewire\Category\ListCategory;
use App\Livewire\Category\ViewCategory;
use App\Livewire\Chat\ListChat;
use App\Livewire\Chat\ViewChat;
use App\Livewire\Dashboard;
use App\Livewire\Order\ListOrder;
use App\Livewire\Order\ViewOrder;
use App\Livewire\Review\ListReview;
use App\Livewire\Shipping\Method\CreateShippingMethod;
use App\Livewire\Shipping\Method\ListShippingMethod;
use App\Livewire\Shipping\Rate\CreateShippingRate;
use App\Livewire\Shipping\Rate\ListShippingRate;
use App\Livewire\Shipping\Rate\ViewShippingRate;
use App\Livewire\Shipping\Zone\CreateShippingZone;
use App\Livewire\Shipping\Zone\ListShippingZone;
use App\Livewire\Specification\CreateSpecification;
use App\Livewire\Specification\EditSpecification;
use App\Livewire\Store\ListStore;
use App\Livewire\User\ListUser;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', Login::class)->name('login')->middleware('guest');
//Route::get('/deploy', [DeployController::class, 'deploy'])->name('delpoy')->middleware('guest');

Route::group(['middleware' => CheckAuth::class], function () {
    //dashboard
    Route::get('dashboard', Dashboard::class)->name('dashboard');

    //user
    Route::group(['prefix' => "user"], function () {
        Route::get('/', ListUser::class)->name('user');
    });

    //store
    Route::group(['prefix' => "store"], function () {
        Route::get('/', ListStore::class)->name('store');
    });

    //product
    Route::group(['prefix' => "product"], function () {
        //  Route::get('/', ListProduct::class)->name('product');
    });

    //order
    Route::group(['prefix' => "order"], function () {
        Route::get('/', ListOrder::class)->name('order');
        Route::get('{id}', ViewOrder::class)->name('order.view');
    });

    //category
    Route::group(['prefix' => "category"], function () {
        Route::get('/', ListCategory::class)->name('category');
        Route::get('create', CreateCategory::class)->name('category.create');
        Route::get('{id}', ViewCategory::class)->name('category.view');
        Route::get('{id}/edit', EditCategory::class)->name('category.edit');
    });

    //specification
    Route::group(['prefix' => "specification"], function () {
        Route::get('create', CreateSpecification::class)->name('specification.create');
        Route::get('{id}/edit', EditSpecification::class)->name('specification.edit');
    });

    //shipping
    Route::group(['prefix' => "shipping"], function () {
        Route::prefix('method')->group(function () {
            Route::get('/', ListShippingMethod::class)->name('shipping.method');
            Route::get('create', CreateShippingMethod::class)->name('shipping.method.create');
        });

        Route::prefix('zone')->group(function () {
            Route::get('/', ListShippingZone::class)->name('shipping.zone');
            Route::get('create', CreateShippingZone::class)->name('shipping.zone.create');
        });

        Route::prefix('rate')->group(function () {
            Route::get('/', ListShippingRate::class)->name('shipping.rate');
            Route::get('create', CreateShippingRate::class)->name('shipping.rate.create');
            Route::get('{shippingZoneId}', ViewShippingRate::class)->name('shipping.rate.view');
        });
    });

    //chat
    Route::group(['prefix' => "chat"], function () {
        Route::get('/', ListChat::class)->name('chat');
        Route::get('{id}', ViewChat::class)->name('chat.view');
    });

    //review
    Route::group(['prefix' => "review"], function () {
        Route::get('/', ListReview::class)->name('review');
        Route::get('{id}', ViewChat::class)->name('chat.view');
    });
});
