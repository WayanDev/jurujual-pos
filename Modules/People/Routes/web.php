<?php

use Illuminate\Support\Facades\Route;
use Modules\People\Http\Controllers\CustomersController;

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

Route::group(['middleware' => 'auth'], function () {

    //Customers
    Route::resource('customers', 'CustomersController');
    Route::post('customers/import', [CustomersController::class, 'import'])->name('customers.import');
    //Suppliers
    Route::resource('suppliers', 'SuppliersController');

});
