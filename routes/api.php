<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


//? Laravel API Sanctum routes (v1)
Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => 'auth:sanctum'], function () {

    // Users
    Route::apiResource('users', 'UsersApiController');
    Route::post('users/register', 'AuthController@register');

    // Products
    Route::apiResource('products', 'ProductsApiController');
    Route::delete('/products/{id}/remove', 'ProductsApiController@remove');

    // Countries
    Route::apiResource('accounts', 'AccountsApiController');
});


//? Laravel API Passport routes (v2)
//todo With Bearer token
Route::group(['prefix' => 'v2', 'as' => 'api2.', 'namespace' => 'Api\V2\Admin', 'middleware' => 'auth:api'], function () {

    Route::get('/user', 'UsersApiController@getUserByToken');
    Route::apiResource('users', 'UsersApiController');
});

//todo Without any token
//! Ostavicu da mogu svi bez tokena da povlace proizvode (public)
Route::group(['prefix' => 'v2', 'as' => 'api2.', 'namespace' => 'Api\V2\Admin'], function () {
    //
    Route::apiResource('products', 'ProductsApiController');
});