<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use App\Models\Chat;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function chat($chatId = null)
    {
        $user = User::with('get_chat')->where('role', 3)->get();
        $chats = Chat::with('visitor')->where('status', 'open')
            ->latest() // latest chat on top
            ->get();

        $messages = collect();
        $chatId = null;

        return view('admin.chat', compact('user', 'messages', 'chatId', 'chats'));
    }
    public function notification()
    {
        return view('admin.notification');
    }

    // public function show($chatId, Request $request)
    // {
    //     $chat = Chat::findOrFail($chatId);
    //     // Get all messages for this chat
    //     $messages = Message::with('user')->where('chat_id', $chatId)
    //         ->orderBy('id')
    //         ->get();

    //     $visitorId = Chat::where('id', $chatId)->value('visitor_id');

    //     // Get the user who owns the chat (from the first message)
    //     $user = User::where('visitor_id', $visitorId)->first();

    //     Message::where('chat_id', $chat->id)
    //         ->where('sender', $user->id)
    //         ->where('is_read', 0)
    //         ->update(['is_read' => 1]);

    //     return view('admin.chat.messages', compact('messages', 'chatId', 'user'));
    // }

    public function show($chatId)
    {
        $chat = Chat::with('visitor')->findOrFail($chatId);
        $visitorId = Chat::where('id', $chatId)->value('visitor_id');
        $user = User::with('get_chat')->where('visitor_id', $visitorId)->first();

        return view('admin.chat.messages', compact('chatId', 'user', 'chat'));
    }

    public function messages(Request $request, $chatId)
    {
        $limit = $request->get('limit', 20);
        $offset = $request->get('offset', 0);
        $prepend = $request->get('prepend', 0); // 1 if load more

        $chat = Chat::with('visitor')->find($chatId);

        // Fetch messages
        $messages = Message::with('user')
            ->where('chat_id', $chatId)
            ->orderBy('id', 'desc')  // newest first
            ->skip($offset)
            ->take($limit)
            ->get();

        // Conditionally reverse
        if (!$prepend) {
            // Initial load: reverse so front shows oldest → newest
            $messages = $messages->reverse()->values();
        }
        // If prepend=true, keep desc → top shows newest first in that batch

        $total = Message::where('chat_id', $chatId)->count();

        return response()->json([
            'data' => $messages,
            'has_more' => ($offset + $messages->count()) < $total,
            'count' => $messages->count(),
            'url' => $chat->visitor->last_url ?? null
        ]);
    }
}
