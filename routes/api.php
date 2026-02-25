<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;


Route::prefix('auth')->group(function () {
    Route::post('/register', [RegisterController::class, 'store']);
    Route::post('/login', [LoginController::class,    'store']);
    Route::delete('/login', [LoginController::class,   'destroy'])->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/tickets', [\App\Http\Controllers\Api\TicketController::class, 'store']);
    Route::get('/tickets', [\App\Http\Controllers\Api\TicketController::class, 'index']);
    Route::get('/tickets/{ticket}', [\App\Http\Controllers\Api\TicketController::class, 'show']);
    Route::patch('/tickets/{ticket}', [\App\Http\Controllers\Api\TicketController::class, 'update']);

    Route::get('/tickets/{ticket}/comments', [\App\Http\Controllers\Api\CommentController::class, 'index']);
    Route::post('/tickets/{ticket}/comments', [\App\Http\Controllers\Api\CommentController::class, 'store']);
    Route::get('/comments/{comment}', [\App\Http\Controllers\Api\CommentController::class, 'show']);
    Route::patch('/comments/{comment}', [\App\Http\Controllers\Api\CommentController::class, 'update']);
    Route::delete('/comments/{comment}', [\App\Http\Controllers\Api\CommentController::class, 'destroy']);

    Route::get('/comments', [\App\Http\Controllers\Api\CommentController::class, 'index']);
});