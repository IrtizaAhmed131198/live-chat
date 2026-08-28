<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatSetting extends Model
{
    protected $fillable = [
        'brand_id',
        'chat_enabled',
        'welcome_message',
        'offline_message',
        'primary_color',
        'popup_delay',
        'chat_position',
        'sound_enabled',
        'ai_enabled',
        'ai_provider',
        'ai_model',
        'ai_prompt',
        'website_knowledge',
        'ai_trained_at',
        'ai_handoff_delay'
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'id', 'brand_id');
    }
}
