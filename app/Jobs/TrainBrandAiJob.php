<?php

namespace App\Jobs;

use App\Models\Brand;
use App\Models\ChatSetting;
use App\Services\Ai\WebsiteExtractorService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class TrainBrandAiJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $brand;

    /**
     * Create a new job instance.
     */
    public function __construct(Brand $brand)
    {
        $this->brand = $brand;
    }

    /**
     * Execute the job.
     */
    public function handle(WebsiteExtractorService $extractor): void
    {
        $url = $this->brand->url ?: ($this->brand->domain ? 'https://' . $this->brand->domain : null);

        if (!$url) {
            Log::info("TrainBrandAiJob: Brand #{$this->brand->id} has no URL or domain to train on.");
            return;
        }

        Log::info("TrainBrandAiJob: Starting website extraction for Brand #{$this->brand->id} from URL: {$url}");

        $knowledge = $extractor->extract($url);

        if ($knowledge) {
            $settings = ChatSetting::firstOrCreate(
                ['brand_id' => $this->brand->id],
                [
                    'chat_enabled'    => 1,
                    'ai_enabled'      => 1,
                    'ai_provider'     => 'ollama',
                    'ai_model'        => 'llama3',
                    'welcome_message' => 'Hello! How can we help you today?',
                ]
            );

            $settings->update([
                'ai_enabled'        => 1,
                'website_knowledge' => $knowledge,
                'ai_trained_at'     => now(),
            ]);

            Log::info("TrainBrandAiJob: Successfully trained AI for Brand #{$this->brand->id} with " . strlen($knowledge) . " bytes of website knowledge.");
        } else {
            Log::warning("TrainBrandAiJob: No knowledge could be extracted for Brand #{$this->brand->id} ({$url}).");
        }
    }
}
