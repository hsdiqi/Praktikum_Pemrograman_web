<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('/pengguna', App\Http\Controllers\Api\PenggunaController::class);
Route::apiResource('/product', App\Http\Controllers\Api\ProductController::class);

