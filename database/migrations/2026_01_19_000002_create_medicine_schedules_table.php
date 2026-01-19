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
        Schema::create('medicine_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Pasien
            $table->foreignId('medicine_id')->constrained()->onDelete('cascade');
            $table->string('dosage'); // "1 tablet", "2 kapsul"
            $table->integer('frequency_per_day'); // 1, 2, 3x sehari
            $table->json('time_slots'); // ["07:00", "13:00", "19:00"]
            $table->string('instruction'); // "Sesudah makan", "Sebelum makan"
            $table->date('start_date');
            $table->date('end_date');
            $table->text('notes')->nullable(); // Catatan khusus dari dokter
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->constrained('users'); // Tenaga kesehatan yang membuat
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicine_schedules');
    }
};
