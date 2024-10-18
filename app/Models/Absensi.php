<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    /** @use HasFactory<\Database\Factories\AbsensiFactory> */
    use HasFactory, HasUuids;

    protected $fillable = [
        'pegawai_id',
        'tanggal_absensi',
        'jam_masuk',
        'jam_keluar',
        'lokasi_gps',
        'status',
        'alasan',
    ];
    protected $casts = [
        'tanggal_absensi' => 'date',
        'jam_masuk' => 'datetime',
        'jam_keluar' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
