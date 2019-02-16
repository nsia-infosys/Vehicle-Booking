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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::resource('/users', 'userController');


Route::post('/cars/searchCar/{data}','carController@searchCar')->name('cars.searchCar');
Route::resource('/cars', 'carController');


Route::post('/drivers/searchDriver/{data}','driverController@searchDriver')->name('drivers.searchDriver');
Route::resource('/drivers', 'driverController');

Route::post('/bookings/reject','bookingController@reject');
Route::resource('/bookings', 'bookingController');

Route::post('/book vehical','bookVehicalController@sendData')->name('book_vehical.sendData');
Route::get('/book a vehical','bookVehicalController@index')->name('book_vehical.sendData');
