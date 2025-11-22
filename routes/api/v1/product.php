<?php

use App\Http\Controllers\Api\V1\Product\ProductController;
use Illuminate\Support\Facades\Route;

// Product routes
Route::prefix('product')->group(function () {
    // List products
    Route::get('/', [ProductController::class, 'index'])->name('product.index');

    // Show specific product
    Route::get('/{id}', [ProductController::class, 'show'])->name('product.show');

    // Store new product
    Route::post('/store', [ProductController::class, 'store'])->name('product.store');

    // Update a product
    Route::post('/update/{id}', [ProductController::class, 'update'])->name('product.update');

    // Delete a product
    Route::delete('/delete/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
});
