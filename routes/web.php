<?php

use App\Http\Controllers\Products\AddProductController;
use App\Http\Controllers\Products\DeleteProductController;
use App\Http\Controllers\Products\EditProductController;
use App\Http\Controllers\Products\SaveProductController;
use App\Http\Controllers\Products\SearchProductController;
use App\Http\Controllers\Products\ShowAllProductsController;
use App\Http\Controllers\Products\UpdateProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Sales\AddSaleController;
use App\Http\Controllers\Sales\SaveSaleController;
use App\Http\Controllers\Sales\ShowAllSalesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('admin')->group(function () {
        Route::get('/products/edit/{product_id}', EditProductController::class)->name('product.edit')->middleware('signed');
        Route::post('/products/edit/{product_id}', UpdateProductController::class);
        Route::delete('/products/delete/{product_id}', DeleteProductController::class)->name('product.delete');
    });

    Route::get('/products/index', ShowAllProductsController::class)->name('product.index');
    Route::get('/products/add', AddProductController::class)->name('product.add');
    Route::post('products/', SaveProductController::class)->name('product.save');
    Route::get('/products/search', SearchProductController::class)->name('product.search');

    Route::get('/sales/index', ShowAllSalesController::class)->name('sale.index');
    Route::get('/sales/add', AddSaleController::class)->name('sale.add');
    Route::post('/sales',SaveSaleController::class)->name('sale.save');

});

require __DIR__ . '/auth.php';
