<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Message;
use App\Events\NewMessage;
use App\Models\Website;
use App\Models\Visitor;
use App\Models\Chat;
use App\Models\User;
use App\Events\VisitorJoined;
use Illuminate\Notifications\Notifiable;
use App\Notifications\NewVisitorNotification;
use Illuminate\Support\Str;
use App\Http\Controllers\Api\VisitorController;

Route::post('/visitor-init', [VisitorController::class, 'postVisitorInit']);
Route::post('/visitor-message', [VisitorController::class, 'postVisitorMessage']);
Route::post('/visitor-chat', [VisitorController::class, 'getChatBySession']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
