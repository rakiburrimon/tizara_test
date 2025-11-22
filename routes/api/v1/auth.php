<?php

use App\Http\Controllers\Api\V1\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

// User registration route
Route::post('/register', [RegisterController::class, 'register']);


