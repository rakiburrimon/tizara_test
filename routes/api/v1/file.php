<?php

use App\Http\Controllers\Api\V1\File\FileController;
use Illuminate\Support\Facades\Route;

// File routes
Route::prefix('file')->group(function () {
    // List files
    Route::get('/', [FileController::class, 'index'])->name('file.index');

    // Show specific file
    Route::get('/{id}', [FileController::class, 'show'])->name('file.show');

    // Store new file
    Route::post('/store', [FileController::class, 'store'])->name('file.store');

    // Update a file
    Route::post('/update/{id}', [FileController::class, 'update'])->name('file.update');

    // Delete a file
    Route::delete('/delete/{id}', [FileController::class, 'destroy'])->name('file.destroy');
});
