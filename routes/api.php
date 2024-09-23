<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\InvestorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use Laravel\Sanctum\Sanctum;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/investor', [ProfileController::class, 'investor_data'])->middleware('auth:sanctum');
Route::post('/login', [UserController::class, 'loginAPI']);
Route::post('/logout', [UserController::class, 'logoutAPI'])->middleware('auth:sanctum');
Route::post('/register', [RegisteredUserController::class, 'registerAPI']);
Route::get('/search/startups', [SearchController::class, 'startupSearchAPI']);
Route::get('/search/investors', [SearchController::class, 'investorSearchAPI']);
Route::post('/invest/{startup_id}', [InvestorController::class, 'investAPI'])->middleware('auth:sanctum');
Route::get('/notifications', [UserController::class, 'getNotifications'])->middleware('auth:sanctum');
Route::post('/notifications/{notification_id}/response', [UserController::class, 'investmentResponse'])->middleware('auth:sanctum');
Route::get('/profile/{id}', [ProfileController::class, 'user_profile_data']);
Route::post('/profile/create', [ProfileController::class, 'create_filterer'])->middleware('auth:sanctum');
Route::post('/profile/update', [ProfileController::class, 'update_filterer'])->middleware('auth:sanctum');
Route::delete('/startup/{id}', [ProfileController::class, 'delete_startup'])->middleware('auth:sanctum');

