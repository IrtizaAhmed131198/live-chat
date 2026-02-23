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
        Schema::table('brand', function (Blueprint $table) {
            $table->after('status', function ($table) {
                $table->string('verify_token')->nullable();
                $table->boolean('is_verified')->default(false);
                $table->timestamp('verified_at')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('brand', function (Blueprint $table) {
            $table->dropColumn(['verify_token', 'is_verified', 'verified_at']);
        });
    }
};
