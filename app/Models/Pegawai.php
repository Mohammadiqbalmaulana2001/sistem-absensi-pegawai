<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    /** @use HasFactory<\Database\Factories\PegawaiFactory> */
    use HasFactory,HasUlids;

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
}
