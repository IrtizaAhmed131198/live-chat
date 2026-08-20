<?php

namespace App\Contracts;

use App\Models\Chat;

interface AiProviderInterface
{
    /**
     * Generate a response for the chat.
     *
     * @param Chat $chat
     * @param string $systemPrompt
     * @param string $model
     * @return string
     */
    public function generateReply(Chat $chat, string $systemPrompt, string $model): string;
}
