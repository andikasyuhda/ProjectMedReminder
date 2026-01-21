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
        Schema::table('schedule_reminders', function (Blueprint $table) {
            $table->foreignId('compliance_log_id')->nullable()->after('id')->constrained('compliance_logs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schedule_reminders', function (Blueprint $table) {
            $table->dropForeign(['compliance_log_id']);
            $table->dropColumn('compliance_log_id');
        });
    }
};
