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

//sredi ovo doda /$id posle campaigns za url kad sredis axios i backend
Route::middleware('auth')->get('/campaign', 'CampaignsController@show')->name('campaign-show');


Route::middleware('auth')->get('/feed', 'PostsController@index')->name('posts');

Route::middleware('auth')->get('/me', 'AccountController@index')->name('account');
