<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use App\Models\Chat;

class AdminController extends Controller
{

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function chat($chatId = null)
    {
        $user = User::where('role', 3)->get();

        $messages = collect();
        $chatId = null;

        return view('admin.chat', compact('user', 'messages', 'chatId'));
    }
    public function notification()
    {
        return view('admin.notification');
    }

    public function show($chatId, Request $request)
    {
        // Get all messages for this chat
        $messages = Message::with('user')->where('chat_id', $chatId)
            ->orderBy('id')
            ->get();

        $visitorId = Chat::where('id', $chatId)->value('visitor_id');

        // Get the user who owns the chat (from the first message)
        $user = User::where('id', $visitorId)->first();

        return view('admin.chat.messages', compact('messages', 'chatId', 'user'));
    }
}
