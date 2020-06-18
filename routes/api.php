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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->get('campaigns', 'ApiCampaignsController@index');
Route::middleware('auth:api')->get('/campaign/{id}', 'ApiCampaignsController@show');
Route::middleware('auth:api')->post('new-campaign', 'ApiCampaignsController@store');

Route::middleware('auth:api')->get('follows', 'ApiFollowsController@index');

Route::middleware('auth:api')->get('categories', 'ApiCategoriesController@index');