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
Route::post('cart/confirmShoppingCart', 'CartController@confirmShoppingCart');

// PRODUCTS
Route::get('products','ProductController@index');
Route::post('products/getCarModels','ProductController@getCarModels');
Route::post('products/getCarParts','ProductController@getCarParts');
Route::post('products/getCarPartsForSale','ProductController@getCarPartsForSale');

//CUSTOMER ORDER
Route::get('orders','CustomerOrderController@index')->middleware('auth.basic');
Route::get('order-to-pdf/{id}','CustomerOrderController@getOrderToPDF')->middleware('auth.basic');

//ADMINISTRATION
Route::get('administration','AdministrationController@index');
Route::get('administration/add-employee', 'AdministrationController@addEmployee');
Route::get('administration/terminate-employee', 'AdministrationController@getEmployeeRc');
Route::get('administration/update-employee', 'AdministrationController@updateEmployee');
Route::get('administration/absence', 'AdministrationController@absence');



//administration EMPLOYEE
Route::post('administration/add-employee/new-employee', 'AdministrationController@createEmployee');
Route::post('administration/terminate-employee/terminate', 'AdministrationController@terminateEmployee');
Route::post('administration/update-employee/getEmployeeData', 'AdministrationController@getEmployeeData');
Route::post('administration/update-employee/updateEmployeeData', 'AdministrationController@updateEmployeeData');
Route::post('administration/absence/employee/employeeAbsence', 'AdministrationController@employeeAbsence');
Route::post('administration/absence/employee/deleteEmployeeAbsence', 'AbsenceController@deleteEmployeeAbsence');
Route::post('administration/absence/employee/addAbsence', 'AbsenceController@addAbsence');
Route::post('administration/absence/employee/updateAbsence', 'AbsenceController@updateAbsence');

//administration CUSTOMER
Route::get('administration/add-customer', 'CustomerController@addCustomer');
Route::post('administration/add-customer/new-customer', 'CustomerController@createCustomer');
Route::post('administration/add-customer/checkData', 'CustomerController@checkData');
Route::get('administration/admin-reservations', 'ReservationController@adminReservations');
Route::post('administration/admin-reservations/deleteReservation', 'ReservationController@deleteReservation');
Route::post('administration/admin-reservations/getWorkHours', 'ReservationController@getWorkHours');
Route::post('administration/admin-reservations/realizeReservation', 'ReservationController@realizeReservation');

//administration CAR PARTS
Route::get('administration/watch-car-parts', 'CarPartsController@watchCarParts')->middleware('warehouse');
Route::post('administration/watch-car-parts/updateCarParts', 'CarPartsController@updateCarParts')->middleware('warehouse');
Route::post('administration/watch-car-parts/getCarPartStock','CarPartsController@getCarPartStock')->middleware('warehouse');
Route::get('administration/administrate-car-parts', 'CarPartsController@administrateCarParts')->middleware('warehouse');
Route::post('administration/administrate-car-parts/checkCarBrandByName', 'CarPartsController@checkCarBrandByName')->middleware('warehouse');
Route::post('administration/administrate-car-parts/addCarBrand', 'CarPartsController@addCarBrand')->middleware('warehouse');
Route::post('administration/administrate-car-parts/checkCarType', 'CarPartsController@checkCarType')->middleware('warehouse');
Route::post('administration/administrate-car-parts/addCarType', 'CarPartsController@addCarType')->middleware('warehouse');
Route::post('administration/administrate-car-parts/getCarTypes', 'CarPartsController@getCarTypes')->middleware('warehouse');
Route::post('administration/administrate-car-parts/addCarPart', 'CarPartsController@addCarPart')->middleware('warehouse');
Route::post('administration/administrate-car-parts/checkCarPart', 'CarPartsController@checkCarPart')->middleware('warehouse');

//administration SERVICES
Route::get('administration/admin-services', 'ServiceController@adminServices')->middleware('service.admin');
Route::post('administration/admin-services/getServiceHours', 'ServiceController@getServiceHours')->middleware('service.admin');
Route::post('administration/admin-services/updateServices', 'ServiceController@updateServices')->middleware('service.admin');
Route::get('administration/addService', 'ServiceController@addService')->middleware('service.admin');
Route::post('administration/addService/addNewService', 'ServiceController@addNewService')->middleware('service.admin');
Route::post('administration/addService/checkNewService', 'ServiceController@checkNewService')->middleware('service.admin');


// GRAPHS
Route::get('administration/week-reservations', 'ReservationController@getWeekReservations');
Route::get('administration/number-of-orders', 'CustomerOrderController@getNumberOfOrders')->middleware('superAdmin');
Route::get('administration/best-month-earnings', 'CarServiceController@bestMonthEarnings')->middleware('superAdmin');
Route::get('administration/best-car-parts-sales', 'CarPartsController@bestCarPartsSales')->middleware('superAdmin');
Route::post('administration/best-car-parts-sales/getBestSalesGraph', 'CarPartsController@getBestSalesGraph')->middleware('superAdmin');


Auth::routes(['verify' => true]);


