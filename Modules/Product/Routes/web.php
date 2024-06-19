<?php

use Illuminate\Support\Facades\Route;
use Modules\Product\Http\Controllers\ProductController;
use Modules\Product\Http\Controllers\CategoriesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => 'auth'], function () {
    //Print Barcode
    Route::get('/products/print-barcode', 'BarcodeController@printBarcode')->name('barcode.print');
    //Product
    Route::resource('products', 'ProductController');

    // Import Excel Route
    Route::post('/products/import', [ProductController::class, 'import'])->name('products.import');

    //Product Category
    Route::resource('product-categories', 'CategoriesController')->except('create', 'show');
    Route::post('/product-categories/import', [CategoriesController::class, 'import'])->name('product-categories.import');
});

