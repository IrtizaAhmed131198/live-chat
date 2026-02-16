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
        Schema::table('visitors', function (Blueprint $table) {
            // Drop foreign key constraint first
            $table->dropForeign(['website_id']);

            // Drop the column
            $table->dropColumn('website_id');

            // Add new brand_id column with foreign key
            $table->integer('brand_id')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visitors', function (Blueprint $table) {
            // Drop brand_id foreign key and column
            $table->dropColumn('brand_id');

            // Restore website_id
            $table->foreignId('website_id')->after('id')->constrained()->cascadeOnDelete();
        });
    }
};
