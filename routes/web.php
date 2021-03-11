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

Route::middleware('auth')->group(static function () {
	Route::resource('units', 'UnitController');
	Route::resource('brand', 'BrandController');
	Route::resource('supplier', 'SupplierController');
	Route::resource('category', 'CategoryController');
	Route::resource('product', 'ProductController');
	Route::resource('customer', 'CustomerController');
	Route::get('orders/markcompleted/{id}', 'OrderController@markAsCompleted');
	Route::resource('orders', 'OrderController');
	Route::resource('stock', 'StockController');
	Route::resource('account', 'SupplierAccountController');
	Route::resource('account', 'SupplierAccountController');
	Route::resource('companies', 'CompanyController');
	Route::resource('users', 'UserController');
});
