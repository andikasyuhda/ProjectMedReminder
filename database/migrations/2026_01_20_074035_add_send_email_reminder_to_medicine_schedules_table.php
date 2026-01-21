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
        Schema::table('medicine_schedules', function (Blueprint $table) {
            $table->boolean('send_email_reminder')->default(true)->after('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medicine_schedules', function (Blueprint $table) {
            $table->dropColumn('send_email_reminder');
        });
    }
};
