<?php

use App\Photo;
use App\Post;
use App\User;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;


Auth::routes();
//Route::get('/home', 'HomeController@index')->name('home');
//Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');


Route::get('/', 'LandingPageController@index')->name('landing-page');

Route::get('/shop', 'ShopController@index')->name('shop.index');
Route::get('/shop/{product}', 'ShopController@show')->name('shop.show');

Route::get('/cart', 'CartController@index')->name('cart.index');
Route::post('/cart/{product}', 'CartController@store')->name('cart.store');
Route::patch('/cart/{product}', 'CartController@update')->name('cart.update');
Route::delete('/cart/{product}', 'CartController@destroy')->name('cart.destroy');
Route::post('/cart/switchToSaveForLater/{product}', 'CartController@switchToSaveForLater')->name('cart.switchToSaveForLater');

Route::delete('/saveForLater/{product}', 'SaveForLaterController@destroy')->name('saveForLater.destroy');
Route::post('/saveForLater/switchToCart/{product}', 'SaveForLaterController@switchToCart')->name('saveForLater.switchToCart');

Route::post('/coupon', 'CouponsController@store')->name('coupon.store');
Route::delete('/coupon', 'CouponsController@destroy')->name('coupon.destroy');

Route::get('/checkout', 'CheckoutController@index')->name('checkout.index')->middleware('auth');
Route::post('/checkout', 'CheckoutController@store')->name('checkout.store');
Route::post('/paypal-checkout', 'CheckoutController@paypalCheckout')->name('checkout.paypal');

Route::get('/guestCheckout', 'CheckoutController@index')->name('guestCheckout.index');


Route::get('/thankyou', 'ConfirmationController@index')->name('confirmation.index');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/search', 'ShopController@search')->name('search');

Route::get('/search-algolia', 'ShopController@searchAlgolia')->name('search-algolia');

Route::middleware('auth')->group(function () {
    Route::get('/my-profile', 'UsersController@edit')->name('ecommerce.users.edit');
    Route::patch('/my-profile', 'UsersController@update')->name('ecommerce.users.update');

    Route::get('/my-orders', 'OrdersController@index')->name('orders.index');
    Route::get('/my-orders/{order}', 'OrdersController@show')->name('orders.show');
});

//? Orders(admin)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/products/orders', 'Admin\OrdersController@index')->name('admin.products.orders');
    Route::get('/admin/products/orders/{order}', 'Admin\OrdersController@show')->name('admin.products.orders.show');
    Route::put('/admin/products/orders/{order}/updateOrder', 'Admin\OrdersController@updateOrder')->name('admin.products.orders.updateOrder');
    Route::put('/admin/products/orders/{order}/shipOrder', 'Admin\OrdersController@shipOrder')->name('admin.products.orders.shipOrder');

    //? Bulk
    Route::post('/admin/products/orders/shipOrders', 'Admin\OrdersController@shipOrders')
        ->name('admin.products.orders.shipOrders');
    Route::post('/admin/products/orders/deleteOrders', 'Admin\OrdersController@deleteOrders')
        ->name('admin.products.orders.deleteOrders');
});


//? Coupons(admin)
Route::group([
    'middleware' => ['auth', 'admin'],
    'namespace' => 'Admin',
    'as' => 'admin.'
], function () {
    Route::resource('/admin/products/coupons', 'CouponsController')
        ->name('index', 'products.coupons') // admin.products.coupons
        ->name('edit', 'products.coupons.edit')
        ->name('update', 'products.coupons.update')
        ->name('destroy', 'products.coupons.destroy');


    Route::post('/admin/products/coupons/addPercentDiscount', 'CouponsController@addPercentDiscount')
        ->name('products.coupons.addPercentDiscount');

    Route::post('/admin/products/coupons/addFixedDiscount', 'CouponsController@addFixedDiscount')
        ->name('products.coupons.addFixedDiscount');


    //? Bulk
    Route::post('/admin/products/coupons/deleteCoupons', 'CouponsController@deleteCoupons')
        ->name('products.coupons.deleteCoupons');
});


//? Stripe test routes
Route::get('/stripe/customers', function () {
    $stripe = Stripe::make(config('services.stripe.secret'));

    $customers = $stripe->customers()->all();

    foreach ($customers['data'] as $customer) {
        return $customer['email'];
    }
});
