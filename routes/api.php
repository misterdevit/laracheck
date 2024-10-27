<?php

use App\Http\Controllers\BugController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

Route::prefix('bugs')->middleware(['auth:sanctum', 'ability:bugs'])
    ->group(function () {
        Route::post('/', [BugController::class, 'store']);
    });

Route::prefix('sites')->middleware(['auth:sanctum', 'ability:sites'])
    ->group(function () {
        Route::get('/', [SiteController::class, 'index']);
        Route::post('/', [SiteController::class, 'store']);
        Route::get('/{site_id}', [SiteController::class, 'show']);
        Route::put('/{site_id}', [SiteController::class, 'update']);
        Route::delete('/{site_id}', [SiteController::class, 'destroy']);
    });
