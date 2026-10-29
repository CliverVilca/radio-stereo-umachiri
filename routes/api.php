<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Admin API routes using controllers
Route::prefix('admin/api')->middleware(['web'])->group(function () {
    Route::apiResource('news', \App\Http\Controllers\Admin\NewsApiController::class);
    Route::apiResource('events', \App\Http\Controllers\Admin\EventApiController::class);
    Route::apiResource('sports', \App\Http\Controllers\Admin\SportsApiController::class);
    Route::apiResource('programs', \App\Http\Controllers\Admin\ProgramApiController::class);
    Route::apiResource('galleries', \App\Http\Controllers\Admin\GalleryApiController::class);
    Route::apiResource('djs', \App\Http\Controllers\Admin\DJApiController::class);
    Route::apiResource('comments', \App\Http\Controllers\Admin\CommentApiController::class);
    
    Route::get('dashboard/stats', [\App\Http\Controllers\Admin\DashboardApiController::class, 'stats']);
    Route::get('analytics', [\App\Http\Controllers\Admin\AnalyticsApiController::class, 'index']);
});