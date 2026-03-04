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
        Schema::create('heatmap_events', function (Blueprint $table) {
            $table->id();
            $table->integer('brand_id');
            $table->string('session_id');
            $table->string('url');
            $table->enum('type', ['click','scroll','rage']);
            $table->integer('x')->nullable();
            $table->integer('y')->nullable();
            $table->integer('scroll_percent')->nullable();
            $table->timestamps();

            $table->index(['brand_id','url']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('heatmap_events');
    }
};
