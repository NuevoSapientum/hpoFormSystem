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

Route::get('/inbox',[
	'middleware' => 'auth',
	'uses' => 'PagesController@inbox'
]);

Route::get('inbox/edit/{type}/{id}', [
	'middleware' => 'auth',
	'uses' => 'PagesController@editInbox'
]);

Route::post('inbox/edit/{type}/{id}', [
	'middleware' => 'auth',
	'uses' => 'PagesController@postInbox'
]);

Route::get('inbox/delete/{type}/{id}', [
	'middleware' => 'auth',
	'uses' => 'PagesController@deleteInbox'
]);

Route::get('approval',[
	'middleware' => 'auth',
	'uses' => 'PagesController@approval'
]);

Route::get('approval/view/{type}/{id}',[
	'middleware' => 'auth',
	'uses' => 'PagesController@viewApproval'
]);

Route::get('/exitForm', [
	'middleware' => 'auth',
	'uses' => 'PagesController@exitForm'
]);

Route::post('/exitForm', [
	'middleware' => 'auth',
	'uses' => 'PagesController@postexitForm'
]);

Route::get('/requestForLeave', [
	'middleware' => 'auth',
	'uses' => 'PagesController@requestForLeave'
]);

Route::post('/requestForLeave', [
	'middleware' => 'auth',
	'uses' => 'PagesController@postrequestForLeave'
]);

Route::get('/changeSchedule', [
	'middleware' => 'auth',
	'uses' => 'PagesController@changeSchedule'
]);

Route::post('/changeSchedule',[
	'middleware' => 'auth',
	'uses' => 'PagesController@postchangeSchedule'
]);

Route::get('/overtimeAuthSlip', [
	'middleware' => 'auth',
	'uses' => 'PagesController@overtimeAuthSlip'
]);

Route::post('/overtimeAuthSlip', [
	'middleware' => 'auth',
	'uses' => 'PagesController@postovertimeAuthSlip'
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
// Route::controllers([
//    'password' => 'Auth\PasswordController',
// ]);

/*Routes for editing a profile of the user*/
Route::get('/editProfile',[
	'middleware' => 'auth','admin',
	'uses' => 'PagesController@getProfile'
]);

Route::post('/editProfile',[
	'middleware' => 'auth','admin',
	'uses' => 'PagesController@postProfile'
]);

/*Route to managing accounts*/
Route::get('/accounts', [
	'middleware' => 'admin',
	'uses' => 'PagesController@accounts'
]);

Route::get('accounts/show/{id}', [
	'middleware' => 'admin',
	'uses' => 'PagesController@show'
]);

Route::post('accounts/show/{id}', [
	'middleware' => 'admin',
	'uses' => 'PagesController@postShow'
]);

Route::get('accounts/resetPassword/{id}', [
	'middleware' => 'admin',
	'uses' => 'PagesController@resetPassword'
]);

Route::post('accounts/resetPassword/{id}', [
	'middleware' => 'admin',
	'uses' => 'PagesController@postResetPassword'
]);