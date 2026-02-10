<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Chat;
use App\Models\Message;

class HandleInactiveChats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:handle-inactive-chats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = now();

        $chats = Chat::where('status', 'open')->get();

        foreach ($chats as $chat) {
            $inactiveMinutes = $chat->last_activity_at
                ? $chat->last_activity_at->diffInMinutes($now)
                : 999;

            // 🟡 2–5 min → agent warning
            if ($inactiveMinutes >= 2 && $inactiveMinutes < 5 && !$chat->agent_warned) {
                Message::create([
                    'chat_id' => $chat->id,
                    'sender' => null,
                    'message' => '⚠ Visitor inactive (2+ minutes)',
                    'is_read' => true
                ]);

                $chat->update(['agent_warned' => true]);
            }

            // 🟠 10–15 min → system message
            if ($inactiveMinutes >= 10 && $inactiveMinutes < 15 && !$chat->system_notified) {
                Message::create([
                    'chat_id' => $chat->id,
                    'sender' => null,
                    'message' => '⏳ Visitor inactive for 10 minutes',
                    'is_read' => true
                ]);

                $chat->update(['system_notified' => true]);
            }

            // 🔴 20–30 min → auto close
            if ($inactiveMinutes >= 20) {
                Message::create([
                    'chat_id' => $chat->id,
                    'sender' => null,
                    'message' => '❌ Chat closed due to inactivity',
                    'is_read' => true
                ]);

                $chat->update([
                    'status' => 'closed',
                    'closed_at' => now()
                ]);
            }
        }
    }
}
