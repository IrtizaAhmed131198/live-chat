<?php

namespace App\Services\Ai;

use App\Contracts\AiProviderInterface;
use InvalidArgumentException;

class AiServiceFactory
{
    public static function make(string $provider): AiProviderInterface
    {
        switch (strtolower($provider)) {
            case 'ollama':
                return new OllamaProvider();
            case 'openai':
                return new OpenAiProvider();
            // case 'gemini':
            //     return new GeminiProvider();
            default:
                throw new InvalidArgumentException("Unsupported AI Provider: {$provider}");
        }
    }
}
