<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});

Route::resource('accounts', 'AccountController');
Route::get('accounts_report', 'AccountController@report');

Route::resource('api/accounts', 'AccountApiController');

Route::resource('transactions', 'TransactionController');
Route::resource('transactions_report', 'TransactionController@report');

Route::resource('tickets', 'TicketController');

Route::controller('report', 'ReportController');

Route::controller('import', 'ImportController');


