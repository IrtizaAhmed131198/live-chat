<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;

class AdminController extends Controller
{

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function chat()
    {
        $user = User::where('role', 'User')->get();

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
        $messages = Message::where('chat_id', $chatId)
            ->orderBy('id')
            ->get();

        // Get the user who owns the chat (from the first message)
        $user = User::where('id', $chatId)->first();

        return view('admin.chat.messages', compact('messages', 'chatId', 'user'));
    }
}
