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
Route::post('/auth', 'PagesController@auth');

// Route::get('/dashboard', function () {
//     return view('dashboard', ['status' => 'active']);
// });

Route::get('/dashboard', 'PagesController@dashboard');
Route::get('/history', 'PagesController@history');
Route::get('exitForm', 'PagesController@exitForm');
Route::get('/requestForLeave', 'PagesController@requestForLeave');
Route::get('/changeSchedule', 'PagesController@changeSchedule');
Route::get('/overtimeAuthSlip', 'PagesController@overtimeAuthSlip');

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