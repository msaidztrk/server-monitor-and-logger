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

    Route::get('/servers', [ServerController::class, 'index']);
    Route::post('/servers', [ServerController::class, 'store']);

    Route::middleware('server.owner')->group(function () {
        Route::get('/servers/{server}/metrics', [MetricController::class, 'index']);
        Route::get('/servers/{server}/logs', [LogController::class, 'index']);
    });
});

Route::middleware('auth:server-api')->group(function () {
    Route::post('/metrics', [MetricController::class, 'store']);
    Route::post('/logs', [LogController::class, 'store']);
});

