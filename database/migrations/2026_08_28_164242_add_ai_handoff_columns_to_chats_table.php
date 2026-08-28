<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('chats', function (Blueprint $table) {
            $table->boolean('ai_pending')->default(false)->after('is_handled_by_ai');
            $table->timestamp('ai_pending_since')->nullable()->after('ai_pending');
            $table->boolean('ai_greeted')->default(false)->after('ai_pending_since');
            $table->boolean('ai_processing')->default(false)->after('ai_greeted');
        });
    }

    public function down(): void
    {
        Schema::table('chats', function (Blueprint $table) {
            $table->dropColumn(['ai_pending', 'ai_pending_since', 'ai_greeted', 'ai_processing']);
        });
    }
};
