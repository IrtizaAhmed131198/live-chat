<?php

namespace App\Services\Ai;

use App\Contracts\AiProviderInterface;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OllamaProvider implements AiProviderInterface
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
            } elseif ($msg->sender == null) {
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
        
        try {
            // Typically Ollama runs on port 11434 locally. Increase timeout to 300s (5 mins) 
            // because large models can take time to load into RAM the first time.
            $response = Http::timeout(300)->post('http://127.0.0.1:11434/api/chat', [
                'model' => $model ?: 'llama3',
                'messages' => $formattedMessages,
                'stream' => false,
                'options' => [
                    'temperature' => 0.2,
                    'num_predict' => 120,
                ],
            ]);
            
            if ($response->successful()) {
                return $response->json('message.content') ?? 'I am sorry, I cannot process your request right now.';
            }
            
            Log::error('Ollama API Error: ' . $response->body());
        } catch (\Exception $e) {
            Log::error('Ollama Exception: ' . $e->getMessage());
        }
        
        return 'I am sorry, I am currently unavailable.';
    }
}
