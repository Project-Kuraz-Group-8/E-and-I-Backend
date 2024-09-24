<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


 // Route for starting a chat with a specific user
 
 Route::get('/chat/{recipientId}', [ChatController::class, 'chatWithUser'])->name('chat.with')->middleware('auth:sanctum');



 // Route for sending a message
 Route::post('/send/message', [ChatController::class, 'sendMessage'])->name('send.message')->middleware('auth:sanctum');

 Route::post('/register', [UserController::class, 'store']);
 