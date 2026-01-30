<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Message;
use App\Events\NewMessage;
use App\Models\Website;
use App\Models\Visitor;
use App\Models\Chat;
use App\Events\VisitorJoined;

Route::post('/visitor-init', function (Request $request) {

    $request->validate([
        'domain' => 'required',
        'session_id' => 'required'
    ]);

    // 1️⃣ Website
    $website = Website::firstOrCreate(
        ['domain' => $request->domain],
        ['name' => $request->domain]
    );

    $sessionId = $request->session_id;

    // 2️⃣ Visitor
    $visitor = Visitor::firstOrCreate([
        'website_id' => $website->id,
        'session_id' => $request->session_id
    ]);

    // ✅ ONLY PUSH IF FIRST TIME VISITOR
    if ($visitor->wasRecentlyCreated) {
        emit_pusher_notification(
            'admin-notifications',
            'visitor-joined',
            [
                'website' => [
                    'id' => $website->id,
                    'domain' => $website->domain,
                ],
                'visitor' => [
                    'id' => $visitor->id,
                    'session_id' => $visitor->session_id,
                ],
            ]
        );
    }

    return response()->json([
        'visitor' => $visitor->id
    ]);
});

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
