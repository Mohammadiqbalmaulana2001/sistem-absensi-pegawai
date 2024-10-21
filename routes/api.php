<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\KameraController;
use App\Http\Controllers\KebijakanAbsensiController;
use App\Http\Controllers\LogAktivitasController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\PegawaiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('/pegawai', PegawaiController::class);
Route::apiResource('/absen' , AbsensiController::class);
Route::apiResource('/lokasi', LokasiController::class);
Route::apiResource('/kamera', KameraController::class);
Route::apiResource('/kebijakan-absensi', KebijakanAbsensiController::class);
Route::apiResource('/log-aktivitas', LogAktivitasController::class);