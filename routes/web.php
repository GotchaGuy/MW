<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware('auth')->get('/campaign/{id}', 'CampaignsController@show')->name('campaign');

Route::middleware('auth')->get('/new-campaign', 'CampaignFormController@index')->name('campaign-form');

Route::middleware('auth')->get('/feed', 'FeedController@index')->name('posts');

Route::middleware('auth')->get('/me', 'AccountController@index')->name('account');
