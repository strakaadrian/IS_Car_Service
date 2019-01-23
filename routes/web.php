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
Route::get('logout', 'Auth\LoginController@logout')->middleware('auth.basic');

// ABOUT
Route::get('about', 'AboutController@index');

// SERVICE
Route::get('service', 'ServiceController@index');
Route::get('service/order-service/{id}' , 'ServiceController@orderService')->middleware('auth.basic');
Route::post('service/order-service/checkInsertReservCond', 'ServiceController@checkInsertReservCond');
Route::post('service/order-service/insertReservation', 'ServiceController@insertReservation');

//RESERVATION
Route::get('reservation', 'ReservationController@index')->middleware('auth.basic');
Route::post('reservation/delete-reservation','ReservationController@deleteFromReservations');

// CUSTOMER
Route::post('create-customer', array('uses' => 'ServiceController@createCustomer'));
Route::post('customer/checkDataCustomer', 'CustomerController@checkDataCustomer');

// PROFILE
Route::get('profile', 'ProfileController@index')->middleware('auth.basic');
Route::post('profile/checkDataProfile', 'ProfileController@checkDataProfile');
Route::post('profile/updateProfile', 'ProfileController@updateProfile');

//CONTACT
Route::get('contact','ContactController@index');
Route::post('contact/getCarServiceByIco', 'ContactController@getCarServiceByIco');

// CART
Route::get('cart','CartController@index')->middleware('auth.basic');
Route::post('cart/updateDataInShoppingCart', 'CartController@updateDataInShoppingCart');
Route::post('cart/deleteItemFromCart', 'CartController@deleteItemFromCart');
Route::post('cart/addItemToShoppingCart', 'CartController@addItemToShoppingCart')->middleware('auth.basic');
Route::get('cart/confirmShoppingCart', 'CartController@confirmShoppingCart');

// PRODUCTS
Route::get('products','ProductController@index');
Route::post('products/getCarModels','ProductController@getCarModels');
Route::post('products/getCarParts','ProductController@getCarParts');
Route::post('products/getCarPartsForSale','ProductController@getCarPartsForSale');

//CUSTOMER ORDER
Route::get('orders','CustomerOrderController@index')->middleware('auth.basic');
Route::get('order-to-pdf/{id}','CustomerOrderController@getOrderToPDF')->middleware('auth.basic');


Auth::routes(['verify' => true]);


