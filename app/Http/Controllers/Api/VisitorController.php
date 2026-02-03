<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Visitor;
use App\Models\Chat;
use App\Models\Message;

class VisitorController extends Controller
{
    public function getChatBySession(Request $request)
    {
        $request->validate([
            'session_id' => 'required'
        ]);

        // 1️⃣ Get visitor via session
        $visitor = Visitor::where('session_id', $request->session_id)->first();

        if (!$visitor) {
            return response()->json([
                'chat_id' => null,
                'messages' => []
            ]);
        }

        // 2️⃣ Get existing chat
        $chat = Chat::where('visitor_id', $visitor->id)
            ->where('status', 'open')
            ->first();

        if (!$chat) {
            return response()->json([
                'chat_id' => null,
                'messages' => []
            ]);
        }

        // 3️⃣ Fetch messages
        $messages = Message::with('user')->where('chat_id', $chat->id)
            ->orderBy('created_at')
            ->get(['message', 'sender', 'created_at']);

        return response()->json([
            'chat_id' => $chat->id,
            'messages' => $messages
        ]);
    }

    public function postVisitorMessage(Request $request)
    {
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
    }

    public function postVisitorInit(Request $request)
    {
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

        $visitorUser = User::firstOrCreate(
            ['visitor_id' => $visitor->id], // optional: link user to visitor
            [
                'name' => 'Visitor-'.$visitor->id,
                'email' => 'visitor'.$visitor->id.'@example.com',
                'password' => bcrypt(Str::random(8)), // random password
                'role' => 3
            ]
        );

        // ✅ ONLY FIRST TIME VISITOR
        if ($visitor->wasRecentlyCreated) {

            // Send DB notification
            $admins = User::where('role', 1)->get();
            foreach ($admins as $admin) {
                $admin->notify(new NewVisitorNotification($website, $visitor));
            }

            // Send Pusher notification
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
    }
}
