<?php

use App\Http\Controllers\CategoryApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('/categories', CategoryApiController::class);

// Route::get('/categories', CategoryApiController::class, 'index');
// Route::post('/categories', CategoryApiController::class, 'store');
// Route::get('/categories/{id}', CategoryApiController::class, 'show');
// Route::put('/categories/{id}', CategoryApiController::class, 'update');
// Route::delete('/categories/{id}', CategoryApiController::class, 'destroy');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
