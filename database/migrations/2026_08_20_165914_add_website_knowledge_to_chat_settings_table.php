<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('chat_settings', 'website_knowledge')) {
            Schema::table('chat_settings', function (Blueprint $table) {
                $table->longText('website_knowledge')->nullable()->after('ai_prompt');
                $table->timestamp('ai_trained_at')->nullable()->after('website_knowledge');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chat_settings', function (Blueprint $table) {
            $table->dropColumn(['website_knowledge', 'ai_trained_at']);
        });
    }
};
