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

Route::middleware('auth:api')->get('user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->post('login', 'Api\LoginController@login');
Route::middleware('auth:api')->get('logout', 'Api\LoginController@logout');
Route::middleware('auth:api')->get('getData', 'Api\DataController@getData');
Route::middleware('auth:api')->get('getVersion', 'Api\DataController@getVersion');
Route::middleware('auth:api')->get('getZip', 'Api\DataController@getZip');
Route::middleware('auth:api')->post('sendData', 'Api\DataController@sendData');

