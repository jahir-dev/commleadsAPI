<?php

use Illuminate\Http\Request;

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




//Route::group(['middleware' => 'cors'], function()
//{
// 	Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
    Route::apiResource('buyers', 'BuyerController');
	Route::apiResource('categories', 'CategoryController');
	Route::apiResource('parentCategories', 'ParentCategoryController');
	Route::apiResource('countries', 'CountryController');
	Route::apiResource('offers', 'OfferController');
	Route::apiResource('messages', 'MessageController');
//});


//working on auth
Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');
Route::post('recover', 'AuthController@recover');
Route::group(['middleware' => ['jwt.auth']], function() {
    Route::get('logout', 'AuthController@logout');
    Route::post('logout', 'AuthController@logout');
});