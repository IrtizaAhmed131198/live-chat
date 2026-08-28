<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('chat_settings', function (Blueprint $table) {
            $table->integer('ai_handoff_delay')->default(60)->after('ai_enabled')
                ->comment('Seconds to wait before AI takes over. Default 60 seconds.');
        });
    }

    public function down(): void
    {
        Schema::table('chat_settings', function (Blueprint $table) {
            $table->dropColumn('ai_handoff_delay');
        });
    }
};
