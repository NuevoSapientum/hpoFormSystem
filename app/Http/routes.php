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

/*Routes for all the pages*/
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

// Authentication routes...

// Login Routes
Route::get('/', [
	'middleware' => 'guest',
	'uses' => 'Auth\AuthController@getLogin'
]);
Route::post('auth/login', [
	'middleware' => 'guest',
	'uses' => 'Auth\AuthController@postLogin'
]);
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', [
	'middleware' => 'admin',
	'uses' => 'Auth\AuthController@getRegister'
]);
Route::post('auth/register', [
	'middleware' => 'admin',
	'uses' => 'Auth\AuthController@postRegister'
]);

// Controller for password
Route::controllers([
   'password' => 'Auth\PasswordController',
]);

/*Route for editing a profile of the user*/
Route::get('/editProfile',[
	'middleware' => 'auth','admin',
	'uses' => 'PagesController@editProfile'
]);