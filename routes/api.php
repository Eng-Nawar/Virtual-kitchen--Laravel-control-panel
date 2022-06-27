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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Client - Public
Route::post('/clientlogin',  'App\Http\Controllers\Api\Client\AuthController@getToken');
Route::post('/clientregister',  'App\Http\Controllers\Api\Client\AuthController@register');
Route::post('/clientitems',  'App\Http\Controllers\Api\Client\ItemController@index');
Route::post('/clientitemsbycat/{id}',  'App\Http\Controllers\Api\Client\ItemController@indexByCategory');
Route::post('/getitembyID/{id}',  'App\Http\Controllers\Api\Client\ItemController@getitembyID');
Route::post('/createorder',  'App\Http\Controllers\Api\Client\OrdersController@store');
Route::post('/getorderbyid/{id}',  'App\Http\Controllers\Api\Client\OrdersController@getorderbyid');
Route::post('/getdeliveriesbyid/{id}',  'App\Http\Controllers\Api\Client\OrdersController@getdeliveriesbyid');
Route::post('/updatestatus',  'App\Http\Controllers\Api\Client\OrdersController@updatestatus');
Route::post('/search_by_name/{name}',  'App\Http\Controllers\Api\Client\ItemController@search_by_name');



//Client - Private
//Route::group(['middleware' => 'auth:api'], function () {
//   });
