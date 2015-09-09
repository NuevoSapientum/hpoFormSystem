<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'PagesController@login');

Route::get('/createAccount', [
	'middleware' => 'auth',
	'uses' => 'PagesController@createAccount'
]);

Route::get('/dashboard', [
	'middleware' => 'auth',
	'uses' => 'PagesController@dashboard'
]);

Route::get('/history', [
	'middleware' => 'auth',
	'uses' => 'PagesController@history'
]);

Route::get('/exitForm', [
	'middleware' => 'auth',
	'uses' => 'PagesController@exitForm'
]);

Route::get('/requestForLeave', [
	'middleware' => 'auth',
	'uses' => 'PagesController@requestForLeave'
]);

Route::get('/changeSchedule', [
	'middleware' => 'auth',
	'uses' => 'PagesController@changeSchedule'
]);

Route::get('/overtimeAuthSlip', [
	'middleware' => 'auth',
	'uses' => 'PagesController@overtimeAuthSlip'
]);


Route::get('/', 'Auth\AuthController@getLogin');

// Authentication routes...
// Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

Route::controllers([
   'password' => 'Auth\PasswordController',
]);
// Route::get('/history', function () {
//     return view('history');
// });

// Route::get('/exitForm', function () {
//     return view('exitForm');
// });

// Route::get('/requestForLeave', function () {
//     return view('requestForLeave');
// });

// Route::get('/changeSchedule', function () {
//     return view('changeSchedule');
// });

// Route::get('/overtimeAuthSlip', function () {
//     return view('overtimeAuthSlip');
// });