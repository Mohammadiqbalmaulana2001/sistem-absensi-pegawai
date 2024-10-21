<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pegawai extends Model
{
    /** @use HasFactory<\Database\Factories\PegawaiFactory> */
    use HasFactory,HasUuids;

    protected $fillable = [
        'id',
        'nama',
        'nip',
        'jabatan',
        'foto',
        'email',
        'no_hp',
        'created_at',
        'updated_at'
    ];

    public function Absens():HasMany
    {
        return $this->hasMany(Absensi::class);
    }
    public function LogAktivitas():HasMany
    {
        return $this->hasMany(log_aktivitas::class);
    }
}
