<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Visitor;
use App\Models\Chat;
use App\Models\Message;
use App\Models\Website;
use App\Models\User;
use Illuminate\Notifications\Notifiable;
use App\Notifications\NewVisitorNotification;
use Illuminate\Support\Str;

class VisitorController extends Controller
{
    public function getChatBySession(Request $request)
    {
        $request->validate([
            'session_id' => 'required',
            'limit' => 'nullable|integer',
            'before_id' => 'nullable|integer',
        ]);

        $limit = $request->limit ?? 20;

        $visitor = Visitor::where('session_id', $request->session_id)->first();
        if (!$visitor) {
            return response()->json([
                'chat_id' => null,
                'messages' => [],
                'unread_count' => 0
            ]);
        }

        $chat = Chat::with('agent', 'visitor')
            ->where('visitor_id', $visitor->id)
            ->where('status', 'open')
            ->first();

        if (!$chat) {
            return response()->json([
                'chat_id' => null,
                'messages' => [],
                'unread_count' => 0
            ]);
        }

        $query = Message::with('user')
            ->where('chat_id', $chat->id)
            ->whereNotNull('sender')
            ->orderBy('id', 'desc'); // newest first

        if ($request->before_id) {
            $query->where('id', '<', $request->before_id);
        }

        $messages = $query->take($limit)->get()->sortBy('id')->values();

        $unreadCount = Message::where('chat_id', $chat->id)
            ->where('sender', $chat->agent_id)
            ->whereNotNull('sender')
            ->where('is_read', false)
            ->count();

        $data = $messages->map(function($msg) {
            return [
                'id' => $msg->id,
                'message' => $msg->message,
                'role' => $msg->user->role ?? $msg->sender,
                'sender' => $msg->sender ?? null,
                'created_at' => $msg->created_at,
                'formatted_created_at' => $msg->formatted_created_at,
            ];
        });

        return response()->json([
            'chat_id' => $chat->id,
            'messages' => $data,
            'unread_count' => $unreadCount
        ]);
    }

    public function postVisitorMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'session_id' => 'required'
        ]);

        // 1️⃣ Get visitor via session
        $visitor = Visitor::where('session_id', $request->session_id)
            ->with('user')
            ->first();

        if (!$visitor) {
            return response()->json([
                'status' => false,
                'message' => 'Visitor not found'
            ], 404);
        }

        $chat = Chat::with('agent', 'visitor')->where('visitor_id', $visitor->id)->latest()->first();

        if (!$chat || $chat->status === 'closed') {
            $chat = Chat::create([
                'visitor_id' => $visitor->id,
                'website_id' => $visitor->website_id,
                'agent_id' => $chat->agent_id ?? 1,
                'status' => 'open',
                'last_visitor_activity_at' => now()
            ]);
        } else {
            $chat->update([
                'last_visitor_activity_at' => now()
            ]);
        }


        $roleId = optional($visitor->user)->role;
        $userId = optional($visitor->user)->id;

        $msg = Message::create([
            'chat_id' => $chat->id,
            'sender'  => $userId,
            'message' => $request->message
        ]);

        emit_pusher_notification(
            'chat.' . $chat->id, // channel
            'new-message',                // event
            [
                'chat_id' => $chat->id,
                'user_id' => $userId,
                'message' => $request->message,
                'sender'  => $userId,
                'sender_type' => 'visitor',
                'role'  => 3,
                'created_at' => $msg->formatted_created_at,
                'formatted_created_at' => $msg->formatted_created_at,
                'id' => $msg->id
            ]
        );

        return response()->json([
            'status' => true,
            'chat_id' => $chat->id,
            'message' => 'Message sent successfully',
        ], 200);
    }

    public function loadMore(Request $request)
    {
        $request->validate([
            'chat_id' => 'required|integer',
            'before_id' => 'required|integer',
        ]);

        $chat = Chat::find($request->chat_id);
        if (!$chat) return response()->json(['messages' => []]);

        $messages = Message::where('chat_id', $chat->id)
            ->where('id', '<', $request->before_id)
            ->whereNotNull('sender')
            ->orderBy('id', 'desc')
            ->limit(10) // fetch 10 older messages
            ->get();

        // return in ascending order
        $messages = $messages->sortBy('id')->values();

        $data = $messages->map(function($msg){
            return [
                'id' => $msg->id,
                'message' => $msg->message,
                'sender_role' => $msg->user->role ?? $msg->sender,
                'sender' => $msg->user->role ?? $msg->sender,
                'created_at' => $msg->created_at,
                'formatted_created_at' => $msg->formatted_created_at,
            ];
        });

        return response()->json(['messages' => $data]);
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
        $visitor = Visitor::firstOrCreate(
            ['session_id' => $request->session_id],
            ['website_id' => $website->id]
        );

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

    public function typing(Request $request)
    {
        $visitor = Visitor::where('session_id', $request->session_id)
            ->with('user')
            ->first();

        $chat = Chat::with('agent', 'visitor')->where('visitor_id', $visitor->id)
            ->where('status', 'open')
            ->first();

        if($chat){
            emit_pusher_notification(
                'chat.' . $chat->id,
                'typing',
                ['role' => 3]
            );
        }


        return response()->json(['status' => true]);
    }

    public function markRead(Request $request)
    {
        $visitor = Visitor::where('session_id', $request->session_id)->first();
        if (!$visitor) return response()->json();

        $chat = Chat::where('visitor_id', $visitor->id)
            ->where('status', 'open')
            ->first();
        if (!$chat) return response()->json(['status' => false]);

        Message::where('chat_id', $chat->id)
            ->where('sender', $chat->agent_id)
            ->update(['is_read' => true]);

        return response()->json(['status' => true]);
    }

    public function chatActivity(Request $request)
    {
        $visitor = Visitor::where('session_id', $request->session_id)->first();
        if (!$visitor) return response()->json();

        $chat = Chat::where('visitor_id', $visitor->id)
            ->where('status', 'open')
            ->first();
        if (!$chat) return response()->json(['status' => false]);

        $msg = Message::create([
            'chat_id' => $chat->id,
            'sender'  => null,
            'message' => $request->message,
            'is_read' => true
        ]);

        emit_pusher_notification(
            'chat.' . $chat->id,
            'activity',
            [
                'message' => $request->message,
                'created_at' => $msg->created_at,
                'formatted_created_at' => $msg->formatted_created_at,
            ]
        );

        return response()->json(['status' => true]);
    }

    public function visitorActivity(Request $request)
    {
        $request->validate([
            'session_id' => 'required',
            'url' => 'required|string'
        ]);

        $visitor = Visitor::where('session_id', $request->session_id)->first();
        if (!$visitor) return response()->json(['status' => false]);

        $visitor->last_url = $request->url;
        $visitor->save();

        $chat = Chat::where('visitor_id', $visitor->id)->where('status', 'open')->first();
        if ($chat) {
            $msg = Message::create([
                'chat_id' => $chat->id,
                'sender' => null,
                'message' => "Visitor navigated to: " . $request->url,
                'is_read' => true
            ]);

            emit_pusher_notification(
                'chat.' . $chat->id,
                'activity',
                [
                    'message' => "Visitor navigated to: " . $request->url,
                    'created_at' => $msg->created_at,
                    'formatted_created_at' => $msg->formatted_created_at,
                ]
            );
        }

        return response()->json(['status' => true]);
    }

    public function visitorHeartbeat(Request $request)
    {
        $visitor = Visitor::where('session_id', $request->session_id)->first();
        if (!$visitor) return response()->json();

        $chat = Chat::where('visitor_id', $visitor->id)
            ->where('status','open')
            ->first();

        if ($chat) {
            $chat->last_visitor_activity_at = now();
            $chat->save();
        }

        return response()->json(['status'=>true]);
    }
}
