<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Message;
use App\Events\NewMessage;

Route::post('/visitor-message', function (Request $request) {

    $request->validate([
        'chat_id' => 'required',
        'message' => 'required|string'
    ]);

    Message::create([
        'chat_id' => $request->chat_id,
        'sender'  => 'visitor',
        'message' => $request->message
    ]);

    broadcast(new NewMessage(
        $request->chat_id,
        $request->message,
        'visitor'
    ));

    return response()->json(['ok' => true]);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
