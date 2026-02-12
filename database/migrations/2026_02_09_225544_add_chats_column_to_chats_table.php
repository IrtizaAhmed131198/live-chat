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
        Schema::table('chats', function (Blueprint $table) {
            $table->after('status', function ($table) {
                $table->timestamp('last_visitor_activity_at')->nullable();
                $table->timestamp('last_agent_activity_at')->nullable();
                $table->timestamp('warned_at')->nullable();
                $table->timestamp('system_message_at')->nullable();
                $table->timestamp('closed_at')->nullable();
                $table->string('closed_reason')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chats', function (Blueprint $table) {
            $table->dropColumn(['last_agent_activity_at', 'closed_by', 'closed_reason']);
        });
    }
};
