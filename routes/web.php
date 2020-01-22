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

/*
	Route::get('/', function () {
	    return view('welcome');
	}); 
*/

Route::get('/', 'MainController@index');
Route::post('/main/login','MainController@login');
Route::get('main/dashboard','MainController@dashboard');
Route::get('main/logout','MainController@logout');
Route::get('/dashboard','DashboardController@index');
Route::resource('clients','ClientController');
Route::resource('sounds','SoundController');
Route::resource('callers','CallerController');
Route::resource('phonebooks','PhonebookController');
Route::resource('switches','SwitcheController');
Route::post('/phonebooks/import', 'ImportController@import'); 
Route::post('/clients/viewclient', 'CommonController@viewclient');
Route::post('/clients/balance', 'CommonController@balance');
Route::post('/clients/createbalance', 'CommonController@createbalance');
Route::get('/recharge','RechargeController@index');
Route::post('/recharge/view','RechargeController@rechargeview');
Route::get('/logs', 'CommonController@logs'); 
Route::get('/send/send_feedback', 'HomeController@sendFeedback'); 
Route::get('/setpassword', 'CommonController@setpassword'); 
Route::get('/updatepassword/{slug}', 'CommonController@updatepassword'); 
Route::post('/logs/view','CommonController@logsview');
Route::post('/caller/callercreateajax', 'CommonController@callercreateajax');
Route::post('/caller/calleridverifyajax', 'CommonController@calleridverifyajax');
Route::post('/sendOtp', 'CommonController@sendOtp');
Route::post('/checkCallerId', 'CommonController@checkCallerId'); 

Route::post('/get_phonebook_table', 'CommonController@get_phonebook_table'); 
Route::post('/phonebooks/addcontactajax', 'CommonController@addcontactajax');
Route::post('/search_contact', 'CommonController@search_contact');
Route::post('/delete_pb_contact', 'CommonController@delete_pb_contact');

Route::post('/phonebook/send_pb_otp', 'CommonController@send_pb_otp');
Route::post('/phonebook/check_pb_otp_ajax', 'CommonController@check_pb_otp_ajax');

Route::post('/checkValidOtp','CommonController@checkValidOtp');

Route::post('/checkCallerValidOtp','CommonController@checkCallerValidOtp');

Route::post('/checkDuplicateContactPhonebook','CommonController@checkDuplicateContactPhonebook');

Route::get('/download_excel', 'CommonController@download_excel')->name('export_excel.excel');
