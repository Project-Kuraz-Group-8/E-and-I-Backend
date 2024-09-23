<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StartupController;

// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('/startups', [StartupController::class, 'index']);
// });




// Route::middleware('auth:api')->post('/startups', [StartupController::class, 'store']);

// Route::apiResource('startups', StartupController::class);
// // Route::post('/api/startups', [StartupController::class, 'store'])->middleware('auth:sanctum');

Route::middleware('auth:api')->group(function () {
    // Display a listing of startups
    Route::get('/startups', [StartupController::class, 'index']);
    
    // Store a newly created startup
    Route::post('/startups', [StartupController::class, 'store']);
    
    // Display the specified startup
    Route::get('/startups/{id}', [StartupController::class, 'show']);
    
    // Update the specified startup
    Route::put('/startups/{id}', [StartupController::class, 'update']);
    
    // Remove the specified startup
    Route::delete('/startups/{id}', [StartupController::class, 'destroy']);
});