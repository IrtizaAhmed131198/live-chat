<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Chat;
use App\Events\NewMessage;

class MessageController extends Controller
{
    public function send(Request $request)
    {
        $userId = auth()->id(); // get currently logged in user id (admin/agent)
        $roleId = auth()->user()->role;

        $msg = Message::create([
            'chat_id' => $request->chat_id,
            'sender'  => $userId, // store the ID
            'message' => $request->message
        ]);

        emit_pusher_notification(
            'chat.' . $request->chat_id, // channel
            'new-message',                // event
            [
                'chat_id' => $request->chat_id,
                'message' => $request->message,
                'sender'  => 'agent',
                'role'  => $roleId,
            ]
        );

        return response()->json(['status' => 'sent']);
    }

    public function chartStart(Request $request)
    {
        $request->validate([
            'visitor_id' => 'required',
            'website_id' => 'required'
        ]);

        // Create chat
        $chat = Chat::create([
            'visitor_id' => $request->visitor_id,
            'website_id' => $request->website_id,
            'agent_id' => auth()->user()->id,
            'status' => 'open'
        ]);

        return response()->json([
            'chat_id' => $chat->id
        ]);
    }
}
