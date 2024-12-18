<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::apiResource('/product', Api\ProductController::class);
Route::apiResource('/customer', Api\CustomerController::class);
Route::get('/cart/{customer_id}', [Api\CartController::class, 'index']);
Route::apiResource('/cart', Api\CartController::class)->except(['index']);
Route::get('/home', [Api\ProductController::class, 'home']);
Route::get('/catalog', [Api\ProductController::class, 'catalog']);
Route::post('/register', [Api\AuthController::class, 'register']);
Route::post('/login', [Api\AuthController::class, 'login']);