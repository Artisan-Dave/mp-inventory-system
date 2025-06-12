<?php

use App\Http\Controllers\Products\AddProductController;
use App\Http\Controllers\Products\EditProductController;
use App\Http\Controllers\Products\SaveProductController;
use App\Http\Controllers\Products\ShowAllProductsController;
use App\Http\Controllers\Products\UpdateProductController;
use App\Http\Controllers\ProfileController;
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

    Route::get('/products/index', ShowAllProductsController::class)->name('product.index');
    Route::get('/products/add', AddProductController::class)->name('product.add');
    Route::post('products/', SaveProductController::class)->name('product.save');
    Route::get('/products/edit/{product_id}', EditProductController::class)->name('product.edit')->middleware('signed');
    Route::post('/products/edit/{product_id}', UpdateProductController::class);

});

require __DIR__ . '/auth.php';
