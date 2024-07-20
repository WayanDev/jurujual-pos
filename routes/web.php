<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PrediksiController;
use App\Http\Controllers\PredictionController;
use App\Http\Controllers\SalesPredictionController;
use App\Http\Controllers\StockPredictionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');

Auth::routes(['register' => true]);

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')
        ->name('home');

    Route::get('/sales-purchases/chart-data', 'HomeController@salesPurchasesChart')
        ->name('sales-purchases.chart');

    Route::get('/current-month/chart-data', 'HomeController@currentMonthChart')
        ->name('current-month.chart');

    Route::get('/payment-flow/chart-data', 'HomeController@paymentChart')
        ->name('payment-flow.chart');
});

// Route Training Penjualan
Route::get('/train-model-penjualan', [SalesPredictionController::class, 'showTrainForm'])->name('train-penjualan');
Route::post('/train-model-penjualan', [SalesPredictionController::class, 'trainModel'])->name('train-model-penjualan');
Route::delete('/training-histories/{id}', [SalesPredictionController::class, 'deleteTrainingHistory'])->name('delete-training-history');

// Route Prediksi Penjualan
Route::get('/prediksi-penjualan', [SalesPredictionController::class, 'index'])->name('prediksi-penjualan');
Route::get('/prediksi-penjualan', [SalesPredictionController::class, 'predictSales'])->name('prediksi-penjualan');
Route::post('/reset-penjualan', [SalesPredictionController::class, 'reset'])->name('reset-penjualan');

// Route Training Stok
Route::get('/train-model-stok', [StockPredictionController::class, 'showTrainFormStok'])->name('train-stok');
Route::post('/train-model-stok', [StockPredictionController::class, 'trainStockModel'])->name('train-model-stok');
Route::delete('/training-histories-stok/{id}', [StockPredictionController::class, 'deleteTrainingHistoryStok'])->name('delete-training-history-stok');
// Route Prediksi Stok
Route::get('/prediksi-stok', [StockPredictionController::class, 'index'])->name('prediksi-stok');
Route::get('/prediksi-stok', [StockPredictionController::class, 'predictStock'])->name('prediksi-stok');
Route::post('/reset-stok', [StockPredictionController::class, 'resetStockPredictions'])->name('reset-stok');










