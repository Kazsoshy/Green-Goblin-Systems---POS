<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\POSController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// POS API Routes - Using auth middleware instead of sanctum to match web auth
Route::middleware('auth')->group(function () {
    Route::get('/products/{id}', [POSController::class, 'getProduct']);
    Route::get('/services/{id}', [POSController::class, 'getService']);
    Route::post('/orders', [POSController::class, 'createOrder']);
    Route::post('/checkout', [POSController::class, 'processCheckout']);
}); 