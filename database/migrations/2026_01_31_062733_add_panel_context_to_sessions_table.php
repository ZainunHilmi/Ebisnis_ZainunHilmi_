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
        Schema::table('sessions', function (Blueprint $table) {
            // Add panel_context column for session isolation
            $table->string('panel_context', 20)->nullable()->after('user_id')->index();
            
            // Add guard_type column to track which guard created the session
            $table->string('guard_type', 20)->nullable()->after('panel_context')->index();
            
            // Add composite index for efficient querying
            $table->index(['user_id', 'panel_context'], 'sessions_user_panel_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sessions', function (Blueprint $table) {
            $table->dropIndex('sessions_user_panel_index');
            $table->dropColumn(['panel_context', 'guard_type']);
        });
    }
};
