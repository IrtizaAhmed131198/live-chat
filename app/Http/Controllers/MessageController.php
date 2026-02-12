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
        $request->validate([
            'chat_id' => 'required',
        ]);

        $chat = Chat::with('visitor', 'agent')->find($request->chat_id);
        if(!$chat){
            return response()->json(['error' => 'Chat not found'], 404);
        }
        $visitorId = $chat->visitor->id; // get currently logged in user id (admin/agent)
        $roleId = $chat->visitor->role;

        $msg = Message::create([
            'chat_id' => $request->chat_id,
            'sender'  => auth()->id(), // store the ID
            'message' => $request->message
        ]);

        emit_pusher_notification(
            'chat.' . $chat->id, // channel
            'new-message',                // event
            [
                'chat_id' => $chat->id,
                'user_id' => auth()->id(),
                'message' => $request->message,
                'sender'  => auth()->id(),
                'role'  => auth()->user()->role ?? 2,
                'formatted_created_at'  => $msg->formatted_created_at,
                'created_at'  => $msg->created_at,
                'id'  => $msg->id,
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

    public function typing(Request $request)
    {
        emit_pusher_notification(
            'chat.' . $request->chat_id,
            'typing',
            ['role' => 2]
        );

        return response()->json(['status' => true]);
    }

    public function markRead(Request $request)
    {
        $chat = Chat::with('visitor')->where('id', $request->chat_id)->first();
        if(!$chat){
            return response()->json(['error' => true]);
        }

        Message::where('chat_id', $chat->id)
            ->where('sender', $chat->visitor->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['status' => true]);
    }

     public function closeChat(Request $request)
     {
         $chat = Chat::find($request->chat_id);
         if (!$chat) {
             return response()->json(['error' => 'Chat not found'], 404);
         }

         $chat->update([
             'status' => 'closed',
             'closed_at' => now()
         ]);

         Message::create([
             'chat_id' => $chat->id,
             'sender' => null,
             'message' => 'Chat closed by agent',
             'is_read' => true
         ]);

         emit_pusher_notification(
             'chat.' . $chat->id,
             'activity',
             [
                 'message' => "Chat closed by agent",
                 'chat_status' => 'closed',
                 'chat_id' => $chat->id,
             ]
         );

         return response()->json(['status' => true]);
     }
}
