<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class log_aktivitas extends Model
{
    /** @use HasFactory<\Database\Factories\LogAktivitasFactory> */
    use HasFactory, HasUuids;

    protected $fillable = [
        'pegawai_id',
        'aktivitas',
        'deskripsi',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
