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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();
Route::post('/users/searchUser/{data}','userController@searchUser');
Route::get('/pendings_users','userController@pendings');
Route::put('/approveUser/{id}','userController@approveUser');
Route::put('/changePassword/{id}','userController@changePassword');
Route::resource('/users', 'userController');
Route::post('/cars/searchCar/{data}','carController@searchCar')->name('cars.searchCar');
Route::resource('/cars', 'carController');


Route::post('/drivers/searchDriver/{data}','driverController@searchDriver')->name('drivers.searchDriver');
Route::resource('/drivers', 'driverController');
Route::post('/bookings/freeCar','bookingController@freeCar');
Route::get('/pending_bookings','bookingController@pendings');

Route::post('/bookings/freeDriver','bookingController@freeDriver');
Route::post('/bookings/reject','bookingController@reject');
Route::resource('/bookings', 'bookingController');
Route::get('/user_permissions','permissionController@user_permissions');
Route::resource('/permissions','permissionController');
Route::get('/user_roles','rolesController@user_roles');
Route::get('/roles/{id}/edit2','rolesController@edit2');
Route::resource('/roles', 'rolesController');

// Route::post('/book vehical','bookVehicalController@sendData')->name('book_vehical.sendData');
// Route::get('/book a vehical','bookVehicalController@index')->name('book_vehical.sendData');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
