<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Middleware\EchoTextMiddleWare;
use Illuminate\Support\Facades\Route;


Route::post('/login', [AuthenticationController::class, 'login']);

Route::middleware(['auth:sanctum',EchoTextMiddleWare::class])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->withoutMiddleware(EchoTextMiddleWare::class);
    Route::get('logout', [AuthenticationController::class, 'logout']);
});

