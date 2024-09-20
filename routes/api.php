<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\SearchController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [UserController::class, 'loginAPI']);
Route::post('/register', [RegisteredUserController::class, 'registerAPI']);
Route::get('/search/{term}', [SearchController::class, 'searchAPI']);
