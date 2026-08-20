<?php

namespace App\Jobs;

use App\Models\Chat;
use App\Models\Message;
use App\Services\Ai\AiServiceFactory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessAIResponseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $chat;

    public function __construct(Chat $chat)
    {
        $this->chat = $chat;
    }

    public function handle()
    {
        $brand = $this->chat->get_brand ?: ($this->chat->brand ?: \App\Models\Brand::find($this->chat->brand_id));
        $settings = $brand ? ($brand->chatSetting ?: \App\Models\ChatSetting::where('brand_id', $brand->id)->first()) : null;

        if (!$settings || !$settings->ai_enabled) {
            Log::warning("ProcessAIResponseJob: AI not enabled or settings missing for Chat #{$this->chat->id}, Brand #{$brand?->id}");
            return;
        }

        try {
            $providerName = $settings->ai_provider ?: 'ollama';
            $model = $settings->ai_model ?: 'llama3';

            $brandName = $brand->name ?: ($brand->domain ?: 'our company');
            $brandUrl = $brand->url ?: ($brand->domain ?: '');
            $customPrompt = $settings->ai_prompt ?: 'You are a professional, helpful, and concise live chat support assistant.';

            $systemPrompt = "{$customPrompt}\n\nYou represent the brand: \"{$brandName}\" ({$brandUrl}).\n\n"
                . "STRICT LIVE CHAT CONSTRAINTS:\n"
                . "1. MAX LENGTH: Your response MUST be 1 to 2 short sentences (under 35 words). Be direct and concise.\n"
                . "2. ACKNOWLEDGMENTS / THANKS: If the user says 'thank you', 'thanks', 'okay', 'ok', or similar, respond ONLY with a short closing like: \"You're welcome! Let me know if you need anything else.\" Never add unsolicited book lists or marketing pitches.\n"
                . "3. NO UNSOLICITED LISTS: Never dump book lists or recommendations unless the user specifically asks for them.\n"
                . "4. DETAIL ON DEMAND: Only give a long response if the visitor explicitly asks (e.g. 'explain in detail', 'give me a full list').\n"
                . "5. ACCURACY: Base your facts only on the website knowledge below.";

            if (!empty($settings->website_knowledge)) {
                $systemPrompt .= "\n\n=== OFFICIAL WEBSITE KNOWLEDGE ===\n"
                    . $settings->website_knowledge . "\n"
                    . "=================================";
            }

            $aiService = AiServiceFactory::make($providerName);

            // Broadcast typing event so visitor knows AI is thinking
            emit_pusher_notification(
                'chat.' . $this->chat->id,
                'typing',
                ['role' => 4]
            );

            $reply = $aiService->generateReply($this->chat, $systemPrompt, $model);

            // Save reply
            $msg = Message::create([
                'chat_id' => $this->chat->id,
                'sender' => null,
                'message' => $reply,
                'is_ai' => true,
                'is_read' => false
            ]);

            // Broadcast via Pusher helper
            emit_pusher_notification(
                'chat.' . $this->chat->id,
                'new-message',
                [
                    'chat_id' => $this->chat->id,
                    'user_id' => 'ai',
                    'message' => $reply,
                    'sender' => 'ai',
                    'sender_type' => 'ai',
                    'role' => 4, // using role 4 for AI
                    'created_at' => $msg->formatted_created_at,
                    'formatted_created_at' => $msg->formatted_created_at,
                    'id' => $msg->id,
                    'is_read' => false,
                    'is_ai' => true
                ]
            );

        } catch (\Exception $e) {
            Log::error('AI processing error: ' . $e->getMessage());
        }
    }
}
