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
        Schema::create('absemsis', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table-> foreignUuid('pegawai_id')->constrained('pegawais');
            $table->date('tanggal_absensi');
            $table->time('jam_masuk')->nullable();
            $table->time('jam_keluar')->nullable();
            $table->string('lokasi_gps')->nullable();
            $table->enum('metode_absensi',['kamera','qr_code'])->default('kamera');
            $table->enum('status',['hadir','izin','terlambat']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absemsis');
    }
};
