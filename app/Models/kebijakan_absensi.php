<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kebijakan_absensi extends Model
{
    /** @use HasFactory<\Database\Factories\KebijakanAbsensiFactory> */
    use HasFactory, HasUuids;

    protected $fillable = [
        'jam_masuk_normal',
        'jam_pulang_normal',
        'batas_keterlambatan_menit',
    ];
}
