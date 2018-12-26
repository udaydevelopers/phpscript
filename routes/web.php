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

// Admin middleware
Route::group(['middleware'=>'admin', 'as' => 'admin.'], function(){

	Route::get('/admin', function(){
		return view('admin.index');
	});
	Route::resource('/admin/users', 'AdminUsersController');
	
});


// Business Owner middleware
Route::group(['middleware'=>'bowner', 'as' => 'bowner.'], function(){

	// Homepage
	Route::get('/bowner', function(){
		return view('bowner.index');
	});

	// Human Resource route
	Route::resource('/bowner/humans', 'BownerHumansController');

	// Salary route
	Route::post('/bowner/salaries', 'BownerSalariesController@index');
	Route::post('/bowner/salaries/store', [
		'uses' => 'BownerSalariesController@store',
		'as' => 'salaries.store' ]);
	Route::resource('/bowner/salaries', 'BownerSalariesController', ['except'=>['store']]);

	// Leave route
	Route::resource('/bowner/leaves', 'LeavesController');

	// Chart route
	Route::get('bowner/chart', [
		'uses' => 'ChartController@index',
		'as' =>'chart.index'
	]);

	// Customer route
	Route::resource('bowner/customer', 'CustomerController', ['except'=>['store']]);


});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
