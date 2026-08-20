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
        Schema::table('chat_settings', function (Blueprint $table) {
            $table->boolean('ai_enabled')->default(false);
            $table->string('ai_provider')->default('ollama');
            $table->string('ai_model')->default('llama3');
            $table->text('ai_prompt')->nullable();
        });

        Schema::table('chats', function (Blueprint $table) {
            $table->boolean('is_handled_by_ai')->default(false);
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->boolean('is_ai')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chat_settings', function (Blueprint $table) {
            $table->dropColumn(['ai_enabled', 'ai_provider', 'ai_model', 'ai_prompt']);
        });

        Schema::table('chats', function (Blueprint $table) {
            $table->dropColumn('is_handled_by_ai');
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn('is_ai');
        });
    }
};
