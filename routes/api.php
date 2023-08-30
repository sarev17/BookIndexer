<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('v1')->group(function(){
    Route::post('auth/token',[AuthController::class,'getToken']);
    Route::get('livros',[BookController::class,'index']);
    Route::name('books')->group(function(){
        Route::post('livros',[BookController::class,'store']);
    })->middleware('api');
});
