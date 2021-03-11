<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->namespace('Api')->group(static function () {
    Route::get('/user', 'LoginController@user');
    Route::resource('units', 'UnitController')->only(['index', 'destroy', 'update', 'store', 'edit']);
    Route::resource('categories', 'CategoryController')->only(['index', 'edit', 'destroy', 'update', 'store']);
    Route::resource('brands', 'BrandController')->only(['index', 'edit', 'destroy', 'update', 'store']);
    Route::resource('customers', 'CustomerController')->only(['index', 'destroy', 'update', 'store', 'edit', 'show']);
    Route::get('products/search', 'ProductController@searchProducts');
    Route::resource('products', 'ProductController')->only(['index', 'show', 'destroy', 'update', 'store', 'edit']);
    Route::resource('suppliers', 'SupplierController')->only(['index', 'edit', 'show', 'destroy', 'update', 'store']);
    Route::resource('supplier/accounts', 'SupplierAccountController')->only(['index', 'show', 'update', 'store']);
    Route::resource('customer/accounts', 'CustomerAccountController')->only(['index', 'show', 'update', 'store']);
    Route::resource('stocks', 'StockController')->only(['index', 'show', 'update', 'store']);
    Route::resource('sales', 'SaleController')->only(['index', 'show', 'update', 'store', 'destroy']);
    Route::get('purchases/completeOrder/{id}', 'PurchaseController@markAsCompleted');
    Route::resource('purchases', 'PurchaseController')->only(['index', 'show', 'update', 'store', 'destroy']);
    Route::get('sales/completeOrder/{id}', 'SaleController@markAsCompleted');
    Route::resource('expenses', 'ExpenseController')->only(['index', 'show', 'update', 'edit', 'store', 'destroy']);
    Route::resource('reports', 'ReportController')->only(['index']);
    Route::get('printBill/{id}', 'BillController@printBill');
    Route::resource('bills', 'BillController')->only(['index', 'show', 'update', 'edit', 'store', 'destroy']);
});

Route::post('login', 'Api\LoginController@login');
