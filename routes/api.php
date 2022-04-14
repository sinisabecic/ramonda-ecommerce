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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


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

Route::get('/user/tokens', function () {
    $user = \App\User::find(1);
    return request()->$user->currentAccessToken()->token;
});

//Route::post('/v1/users/register', 'Api\V1\Admin\AuthController@register');