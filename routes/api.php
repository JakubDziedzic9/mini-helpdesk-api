<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;


Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/tickets', [\App\Http\Controllers\Api\TicketController::class, 'store']);
    Route::get('/tickets/archive', [\App\Http\Controllers\Api\TicketController::class, 'archiveIndex']);
    Route::get('/tickets', [\App\Http\Controllers\Api\TicketController::class, 'index']);
    Route::get('/tickets/{ticket}', [\App\Http\Controllers\Api\TicketController::class, 'show']);
    Route::patch('/tickets/{ticket}', [\App\Http\Controllers\Api\TicketController::class, 'update']);
    Route::post('/tickets/{ticket}/archive', [\App\Http\Controllers\Api\TicketController::class, 'archive']);
});