<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\VisitorController;
use App\Http\Controllers\Api\HeatmapController;

Route::post('/visitor-init', [VisitorController::class, 'postVisitorInit']);
Route::post('/visitor-message', [VisitorController::class, 'postVisitorMessage']);
Route::post('/visitor-chat', [VisitorController::class, 'getChatBySession']);
Route::post('/visitor-typing', [VisitorController::class, 'typing']);
Route::post('/visitor-read', [VisitorController::class, 'markRead']);
Route::post('/visitor-load-more', [VisitorController::class, 'loadMore']);
Route::post('/visitor-chat-activity', [VisitorController::class, 'chatActivity']);
Route::post('/visitor-activity', [VisitorController::class, 'visitorActivity']);
Route::post('/visitor-heartbeat', [VisitorController::class, 'visitorHeartbeat']);
Route::post('/verify-brand', [VisitorController::class, 'verifyBrand']);
Route::post('/offline-message', [VisitorController::class, 'offlineMessage']);

Route::post('/heatmap-track', [HeatmapController::class, 'store']);
Route::get('/heatmap', [HeatmapController::class, 'getAdminHeatmap']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
