<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\VisitorController;

Route::post('/visitor-init', [VisitorController::class, 'postVisitorInit']);
Route::post('/visitor-message', [VisitorController::class, 'postVisitorMessage']);
Route::post('/visitor-chat', [VisitorController::class, 'getChatBySession']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
