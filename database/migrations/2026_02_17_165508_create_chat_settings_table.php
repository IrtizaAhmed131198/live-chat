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
        Schema::create('chat_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('brand_id')->nullable();
            $table->boolean('chat_enabled')->default(true);
            $table->string('welcome_message')->nullable();
            $table->string('offline_message')->nullable();
            $table->string('primary_color')->default('#696cff');
            $table->integer('popup_delay')->default(5);
            $table->enum('chat_position', ['left', 'right']);
            $table->boolean('sound_enabled')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_settings');
    }
};
