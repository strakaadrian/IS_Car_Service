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

// HOME
Route::get('/', 'HomeController@index');
Route::get('home', 'HomeController@index');

// LOGOUT
Route::get('logout', 'Auth\LoginController@logout')->middleware('auth.basic');;

// ABOUT
Route::get('about', 'AboutController@index');

// SERVICE
Route::get('service', 'ServiceController@index');
Route::get('service/order-service/{id}' , 'ServiceController@orderService')->middleware('auth.basic');
Route::post('service/order-service/checkInsertReservCond', 'ServiceController@checkInsertReservCond');
Route::post('service/order-service/insertReservation', 'ServiceController@insertReservation');

//RESERVATION
Route::get('reservation', 'ReservationController@index')->middleware('auth.basic');;

// CUSTOMER
Route::post('create-customer', array('uses' => 'ServiceController@createCustomer'));


Auth::routes(['verify' => true]);


