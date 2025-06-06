<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RatingController;

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


Route::post('/rate/{productId}', [RatingController::class, 'rateProduct']);
Route::post('/remove-rating/{productId}', [RatingController::class, 'removeRating']);
Route::get('/products', [RatingController::class, 'listProducts']);


