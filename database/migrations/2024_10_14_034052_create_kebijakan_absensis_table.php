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
        Schema::create('kebijakan_absensis', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->time('jam_masuk_normal');
            $table->time('jam_pulang_normal');
            $table->integer('batas_keterlambatan_menit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kebijakan_absensis');
    }
};
