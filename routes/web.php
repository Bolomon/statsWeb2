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


Route::get('/', 'HomeController@welcome')->name('welcome');
Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::group(['middleware'=>'guest'], function(){
    Route::get('/vk/auth', 'SocialController@index')->name('vk.auth');
    Route::get('/vk/auth/callback', 'SocialController@callback');
});
