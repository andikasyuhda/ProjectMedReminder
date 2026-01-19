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
        Schema::create('compliance_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->constrained('medicine_schedules')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('scheduled_date');
            $table->time('scheduled_time');
            $table->enum('status', ['pending', 'completed', 'missed'])->default('pending');
            $table->timestamp('taken_at')->nullable();
            $table->text('notes')->nullable(); // Catatan pasien saat check-in
            $table->timestamps();
            
            // Unique constraint untuk mencegah duplikasi
            $table->unique(['schedule_id', 'scheduled_date', 'scheduled_time'], 'unique_compliance');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compliance_logs');
    }
};
