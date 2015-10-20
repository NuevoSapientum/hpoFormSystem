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

Route::get('/index', [
	'middleware' => 'auth',
	'uses' => 'PagesController@index'
]);

/*Routes for all the pages*/
Route::get('/dashboard', [
	'middleware' => 'auth',
	'uses' => 'PagesController@dashboard'
]);

Route::get('/history', [
	'middleware' => 'auth',
	'uses' => 'PagesController@history'
]);

Route::get('history/edit/{type}/{id}', [
	'middleware' => 'auth',
	'uses' => 'InboxController@editForm'
]);

Route::post('history/edit/{type}/{id}', [
	'middleware' => 'auth',
	'uses' => 'InboxController@postForm'
]);

Route::get('history/delete/{type}/{id}', [
	'middleware' => 'auth',
	'uses' => 'InboxController@deleteForm'
]);

Route::get('history/view/{type}/{id}', [
	'middleware' => 'auth',
	'uses' => 'InboxController@viewForm'
]);

Route::get('submittedforms', [
	'middleware' => 'admin',
	'uses' => 'PagesController@submittedForms'
]);

Route::get('submittedforms/edit/{type}/{id}', [
	'middleware' => 'auth',
	'uses' => 'PagesController@editForm'
]);

Route::get('submittedforms/view/{type}/{id}', [
	'middleware' => 'auth',
	'uses' => 'PagesController@editForm'
]);

Route::post('submittedforms/edit/{type}/{id}', [
	'middleware' => 'auth',
	'uses' => 'PagesController@postForm'
]);

Route::get('submittedforms/delete/{type}/{id}', [
	'middleware' => 'auth',
	'uses' => 'PagesController@deleteForm'
]);

Route::get('record/vacation',[
	'middleware' => 'admin',
	'uses' => 'LeaveController@vacationRecord'
]);

Route::get('record/sick',[
	'middleware' => 'admin',
	'uses' => 'LeaveController@sickRecord'
]);

Route::get('record/maternal',[
	'middleware' => 'admin',
	'uses' => 'LeaveController@maternalRecord'
]);

Route::get('record/paternal',[
	'middleware' => 'admin',
	'uses' => 'LeaveController@paternalRecord'
]);

Route::get('record/vacation/view/{type}/{id}', [
	'middleware' => 'admin',
	'uses' => 'LeaveController@view'
]);

Route::get('record/vacation/view/{id}', [
	'middleware' => 'admin',
	'uses' => 'LeaveController@viewUserVacations'
]);

Route::get('record/sick/view/{type}/{id}', [
	'middleware' => 'admin',
	'uses' => 'LeaveController@view'
]);

Route::get('record/sick/view/{id}', [
	'middleware' => 'admin',
	'uses' => 'LeaveController@viewUserSick'
]);

Route::get('record/maternal/view/{type}/{id}', [
	'middleware' => 'admin',
	'uses' => 'LeaveController@view'
]);

Route::get('record/maternal/view/{id}', [
	'middleware' => 'admin',
	'uses' => 'LeaveController@viewUserMaternal'
]);

Route::get('record/paternal/view/{type}/{id}', [
	'middleware' => 'admin',
	'uses' => 'LeaveController@view'
]);

Route::get('record/paternal/view/{id}', [
	'middleware' => 'admin',
	'uses' => 'LeaveController@viewUserPaternal'
]);

/*Routes for the Inbox of the user*/

Route::get('/inbox',[
	'middleware' => 'auth',
	'uses' => 'InboxController@inbox'
]);

Route::get('inbox/edit/{type}/{id}', [
	'middleware' => 'auth',
	'uses' => 'InboxController@editForm'
]);

Route::get('inbox/view/{type}/{id}', [
	'middleware' => 'auth',
	'uses' => 'InboxController@editForm'
]);

Route::post('inbox/edit/{type}/{id}', [
	'middleware' => 'auth',
	'uses' => 'InboxController@postForm'
]);

Route::get('inbox/delete/{type}/{id}', [
	'middleware' => 'auth',
	'uses' => 'InboxController@deleteForm'
]);

/*Routes for the Approvers*/

Route::get('approval',[
	'middleware' => 'auth',
	'uses' => 'ApprovalController@index'
]);

Route::get('approval/view/{type}/{id}',[
	'middleware' => 'auth',
	'uses' => 'ApprovalController@viewApproval'
]);

Route::post('approval/view/{type}/{id}',[
	'middleware' => 'auth',
	'uses' => 'ApprovalController@permissionerApproval'
]);

/*Routes for the view/add a Form*/

Route::get('/exitForm', [
	'middleware' => 'auth',
	'uses' => 'FormController@exitForm'
]);

Route::post('/exitForm', [
	'middleware' => 'auth',
	'uses' => 'FormController@postexitForm'
]);

Route::get('/requestForLeave', [
	'middleware' => 'auth',
	'uses' => 'FormController@requestForLeave'
]);

Route::post('/requestForLeave', [
	'middleware' => 'auth',
	'uses' => 'FormController@postrequestForLeave'
]);

Route::get('/changeSchedule', [
	'middleware' => 'auth',
	'uses' => 'FormController@changeSchedule'
]);

Route::post('/changeSchedule',[
	'middleware' => 'auth',
	'uses' => 'FormController@postchangeSchedule'
]);

Route::get('/overtimeAuthSlip', [
	'middleware' => 'auth',
	'uses' => 'FormController@overtimeAuthSlip'
]);

Route::post('/overtimeAuthSlip', [
	'middleware' => 'auth',
	'uses' => 'FormController@postovertimeAuthSlip'
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

/*Routes for editing a profile of the user*/
Route::get('/editProfile',[
	'middleware' => 'auth','admin',
	'uses' => 'ProfileController@index'
]);

Route::post('/editProfile',[
	'middleware' => 'auth','admin',
	'uses' => 'ProfileController@update'
]);

/*Route to managing accounts*/
Route::get('/accounts', [
	'middleware' => 'admin',
	'uses' => 'AccountController@index'
]);

Route::get('accounts/show/{id}', [
	'middleware' => 'admin',
	'uses' => 'AccountController@show'
]);

Route::post('accounts/show/{id}', [
	'middleware' => 'admin',
	'uses' => 'AccountController@update'
]);

Route::get('accounts/resetPassword/{id}', [
	'middleware' => 'admin',
	'uses' => 'AccountController@resetPassword'
]);

Route::post('accounts/resetPassword/{id}', [
	'middleware' => 'admin',
	'uses' => 'AccountController@postResetPassword'
]);

Route::post('accounts/changeEntitlement', [
	'middleware' => 'admin',
	'uses' => 'AccountController@changeEntitlement'
]);

Route::post('accounts/addDepartment', [
	'middleware' => 'admin',
	'uses' => 'AccountController@addDepartment'
]);

Route::post('accounts/addPosition', [
	'middleware' => 'admin',
	'uses' => 'AccountController@addPosition'
]);