<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Events\NewMessage;

class MessageController extends Controller
{
    public function send(Request $request)
    {
        $msg = Message::create([
            'chat_id' => $request->chat_id,
            'sender'  => 'agent',
            'message' => $request->message
        ]);

        broadcast(new NewMessage(
            $request->chat_id,
            $request->message,
            'agent'
        ))->toOthers();

        return response()->json(['status' => 'sent']);
    }
}
