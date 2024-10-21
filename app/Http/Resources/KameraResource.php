<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KameraResource extends JsonResource
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
            'tipe_kamera' => $this->tipe_kamera,
            'perangkat' => $this->perangkat,
            'status_kamera' => $this->status_kamera,
            'lokasi_id' => $this->lokasi_id,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'lokasi' => new LokasiResource($this->whenLoaded('lokasi'))
        ];
    }
}
