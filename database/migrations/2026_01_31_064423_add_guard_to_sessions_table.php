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
            // Add guard column untuk tracking session milik panel mana
            $table->string('guard', 20)->nullable()->after('user_id')->index();
            
            // Add user_type column untuk tracking user type (admin/user)
            $table->string('user_type', 20)->nullable()->after('guard')->index();
            
            // Add index untuk mempercepat query
            $table->index(['user_id', 'guard'], 'sessions_user_guard_index');
            $table->index(['user_id', 'user_type'], 'sessions_user_type_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sessions', function (Blueprint $table) {
            $table->dropIndex('sessions_user_guard_index');
            $table->dropIndex('sessions_user_type_index');
            $table->dropColumn(['guard', 'user_type']);
        });
    }
};
