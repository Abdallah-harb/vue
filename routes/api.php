<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Blog\BlogController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
Route::middleware('web')->group(function () {

    Route::get('/user', function (Request $request) {
        return jsonResponse(['user' => $request->user()]);
    })->middleware('auth:sanctum');

    Route::controller(AuthController::class)->prefix('auth')->group(function (){
        Route::post('register','register');
        Route::post('login','login');
        Route::post('logout','logout')->middleware('auth:sanctum');
    });

    Route::middleware('auth:sanctum')->group(function (){
        Route::apiResource('blogs',BlogController::class);
    });
});


