<?php

use App\Http\Controllers\Server\LogController;
use App\Http\Controllers\Server\MetricController;
use App\Http\Controllers\Server\ServerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/servers', [ServerController::class, 'store']);
});

Route::middleware('auth:server-api')->group(function () {
    Route::post('/metrics', [MetricController::class, 'store']);
    Route::post('/logs', [LogController::class, 'store']);
});
