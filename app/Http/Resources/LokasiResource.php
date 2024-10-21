<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LokasiResource extends JsonResource
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
            'nama_lokasi' => $this->nama_lokasi,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'radius_validasi' => $this->radius_validasi,
            'created_at' => $this->created_at ?$this->created_at->format('Y-m-d H:i:s') : null,
            'updated_at' => $this->updated_at ? $this->updated_at->format('Y-m-d H:i:s') : null,
            'absensi' => AbsenResource::collection($this->whenLoaded('absensi')),
            'kameras' => KameraResource::collection($this->whenLoaded('kameras'))
        ];
    }
}
