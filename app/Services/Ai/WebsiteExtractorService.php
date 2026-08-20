<?php

namespace App\Services\Ai;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WebsiteExtractorService
{
    /**
     * Extract clean readable knowledge text from a given website URL.
     *
     * @param string $url
     * @return string|null
     */
    public function extract(string $url): ?string
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            // Prepend https:// if missing
            $url = 'https://' . ltrim($url, '/');
        }

        try {
            $response = Http::timeout(20)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36 LiveChatBot/1.0',
                    'Accept'     => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                ])
                ->withoutVerifying()
                ->get($url);

            if (!$response->successful()) {
                Log::warning("WebsiteExtractorService: Failed to fetch {$url} - Status: " . $response->status());
                return null;
            }

            $html = $response->body();
            return $this->cleanHtml($html, $url);

        } catch (\Exception $e) {
            Log::error("WebsiteExtractorService error fetching {$url}: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Clean and format raw HTML into structured knowledge text.
     */
    protected function cleanHtml(string $html, string $url): string
    {
        // Remove script, style, noscript, svg, header, footer, nav tags along with their contents
        $cleaned = preg_replace('/<(script|style|noscript|svg|header|footer|nav|select|iframe)\b[^>]*>(.*?)<\/\1>/is', ' ', $html);

        // Extract title if present
        $title = '';
        if (preg_match('/<title\b[^>]*>(.*?)<\/title>/is', $html, $matches)) {
            $title = trim(strip_tags($matches[1]));
        }

        // Extract meta description
        $metaDescription = '';
        if (preg_match('/<meta\s+name=["\']description["\']\s+content=["\'](.*?)["\']/is', $html, $matches)) {
            $metaDescription = trim($matches[1]);
        }

        // Strip remaining HTML tags
        $text = strip_tags($cleaned);

        // Decode HTML entities
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        // Normalize whitespaces and line breaks
        $text = preg_replace('/[ \t]+/', ' ', $text);
        $text = preg_replace('/\n\s*\n+/', "\n", $text);
        $text = trim($text);

        // Build knowledge summary
        $knowledge = "Website: " . $url . "\n";
        if (!empty($title)) {
            $knowledge .= "Title: " . $title . "\n";
        }
        if (!empty($metaDescription)) {
            $knowledge .= "Description: " . $metaDescription . "\n";
        }
        $knowledge .= "Content:\n" . $text;

        // Limit length to ~12,000 characters to fit well inside Ollama context
        if (mb_strlen($knowledge) > 12000) {
            $knowledge = mb_substr($knowledge, 0, 12000) . "\n...[Additional website content truncated]";
        }

        return $knowledge;
    }
}
