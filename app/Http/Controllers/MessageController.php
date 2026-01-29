<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Events\NewMessage;

class MessageController extends Controller
{
    public function send(Request $request)
    {
        $userId = auth()->id(); // get currently logged in user id (admin/agent)

        $msg = Message::create([
            'chat_id' => $request->chat_id,
            'sender'  => $userId, // store the ID
            'message' => $request->message
        ]);

        broadcast(new NewMessage(
            $request->chat_id,
            $request->message,
            $userId // broadcast sender id
        ))->toOthers();

        return response()->json(['status' => 'sent']);
    }
}
