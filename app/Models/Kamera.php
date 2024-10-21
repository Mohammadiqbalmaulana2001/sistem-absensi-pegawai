<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kamera extends Model
{
    /** @use HasFactory<\Database\Factories\KameraFactory> */
    use HasFactory,HasUuids;

    protected $fillable = [
        'tipe_kamera',
        'perangkat',
        'status_kamera',
        'lokasi_id'
    ];
    public function lokasi():BelongsTo
    {
        return $this->belongsTo(Lokasi::class);
    }
}
