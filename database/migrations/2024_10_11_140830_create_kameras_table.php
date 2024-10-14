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
        Schema::create('kameras', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('tipe_kamera');
            $table->string('perangkat');
            $table->boolean('status_kamera')->default(true);
            $table->foreignUuid('lokasi_id')->constrained('lokasis');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kameras');
    }
};
