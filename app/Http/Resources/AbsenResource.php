<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AbsenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'pegawai_id' => $this->pegawai_id,
            'tanggal_absensi' => $this->tanggal_absensi->format('Y-m-d'),
            'jam_masuk' => $this->jam_masuk ? $this->jam_masuk->format('H:i:s') : null,
            'jam_keluar' => $this->jam_keluar ? $this->jam_keluar->format('H:i:s') : null,
            'lokasi_gps' => $this->lokasi_gps,
            'lokasi_id' => $this->lokasi_id,
            'status' => $this->status,
            'alasan' => $this->alasan,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'pegawai' => new PegawaiResource($this->whenLoaded('pegawai')),
            'lokasi' => new LokasiResource($this->whenLoaded('lokasi')),
        ];
    }
}
