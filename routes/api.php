<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketMessageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('logout', [AuthController::class, 'logout']);

    Route::get('ticket', [TicketController::class, 'index']);
    Route::post('ticket', [TicketController::class, 'store']);
    Route::get('ticket/{ticket}', [TicketController::class, 'show']);
    Route::put('ticket/{ticket}', [TicketController::class, 'update']);
    Route::delete('ticket/{ticket}', [TicketController::class, 'destroy']);

    Route::get('tickets/{ticket}/reply', [TicketMessageController::class, 'index']);

    Route::group(['middleware' => ['role:admin']], function () {
        Route::get('user', [UserController::class, 'index']);
        Route::post('user', [UserController::class, 'store']);
        Route::delete('user/{user}', [UserController::class, 'destroy']);
    });

});
