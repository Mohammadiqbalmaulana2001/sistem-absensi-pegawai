<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    /** @use HasFactory<\Database\Factories\LokasiFactory> */
    use HasFactory,HasUuids;

    protected $fillable = [
        'id',
        'nama_lokasi',
        'latitude',
        'longitude',
        'radius_validasi',
        'created_at',
        'updated_at',
    ];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function Absensi()
    {
        return $this->hasMany(Absensi::class);
    }

    public function Kameras()
    {
        return $this->hasMany(Kamera::class);
    }
}
