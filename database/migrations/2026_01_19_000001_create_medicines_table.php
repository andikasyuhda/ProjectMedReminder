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
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique(); // OBT-001
            $table->string('name');
            $table->string('generic_name')->nullable(); // Nama generik
            $table->string('dosage_form'); // tablet, kapsul, sirup, dll
            $table->string('strength'); // 500mg, 10mg, dll
            $table->string('category'); // Antihipertensi, Diuretik, ACE Inhibitor, dll
            $table->text('description')->nullable();
            $table->text('side_effects')->nullable();
            $table->text('contraindications')->nullable(); // Kontraindikasi
            $table->text('instructions')->nullable(); // Petunjuk penggunaan umum
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
