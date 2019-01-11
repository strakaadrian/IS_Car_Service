<?php

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

Route::get('/', 'HomeController@index');
Route::get('home', 'HomeController@index');

Route::get('logout', 'Auth\LoginController@logout');

Route::get('about', 'AboutController@index');

Route::get('service', 'ServiceController@index');
Route::get('service/order-service/{id}' , 'ServiceController@orderService')->middleware('auth.basic');

Auth::routes(['verify' => true]);


