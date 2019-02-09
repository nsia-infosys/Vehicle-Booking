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


Route::resource('/bookings', 'bookingController');

Route::post('/car booking','book_a_car@sendData')->name('car_book.sendData');
Route::get('/bookD','book_a_car@driversData');