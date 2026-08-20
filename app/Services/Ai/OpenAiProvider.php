<?php

namespace App\Services\Ai;

use App\Contracts\AiProviderInterface;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenAiProvider implements AiProviderInterface
{
    public function generateReply(Chat $chat, string $systemPrompt, string $model): string
    {
        $messages = Message::where('chat_id', $chat->id)->orderBy('id', 'asc')->get();
        
        $formattedMessages = [];
        
        // Add system prompt
        if (!empty($systemPrompt)) {
            $formattedMessages[] = [
                'role' => 'system',
                'content' => $systemPrompt
            ];
        }
        
        foreach ($messages as $msg) {
            $role = 'user';
            
            if ($msg->is_ai) {
                $role = 'assistant';
            } elseif ($msg->sender === null) {
                // Ignore activity messages
                continue;
            } elseif ($msg->user && $msg->user->role != 3) {
                // Real agent message
                $role = 'assistant';
            }
            
            $formattedMessages[] = [
                'role' => $role,
                'content' => $msg->message
            ];
        }
        
        $apiKey = config('services.openai.api_key', env('OPENAI_API_KEY'));
        
        if (empty($apiKey)) {
            Log::error('OpenAiProvider: OPENAI_API_KEY is not configured in .env file.');
            return 'AI service is currently not configured.';
        }
        
        try {
            $payload = [
                'model'                 => $model ?: 'gpt-4o-mini',
                'messages'              => $formattedMessages,
                'max_completion_tokens' => 150,
            ];

            // Only add temperature for non-o1/o3 reasoning models
            if (!str_starts_with($model, 'o1') && !str_starts_with($model, 'o3')) {
                $payload['temperature'] = 0.2;
            }

            $response = Http::withToken($apiKey)
                ->timeout(30)
                ->post('https://api.openai.com/v1/chat/completions', $payload);
            
            if ($response->successful()) {
                return $response->json('choices.0.message.content') ?? 'I am sorry, I cannot process your request right now.';
            }
            
            Log::error('OpenAI API Error: ' . $response->body());
        } catch (\Exception $e) {
            Log::error('OpenAI Exception: ' . $e->getMessage());
        }
        
        return 'I am sorry, I am currently unavailable.';
    }
}
