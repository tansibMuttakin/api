<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\LoginController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/login',[LoginController::class,'login']);

Route::middleware('auth')->get('/me', function () {
    return auth()->user();
});

Route::apiResource('/products', ProductController::class);

Route::group(['prefix' => 'products'], function () {
    Route::apiResource('/{product}/reviews',ReviewController::class);
});
