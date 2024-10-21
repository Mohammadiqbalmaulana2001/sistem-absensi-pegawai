<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LogAktivitasResource extends JsonResource
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
            'aktivitas' => $this->aktivitas,
            'deskripsi' => $this->deskripsi,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'pegawai' => new PegawaiResource($this->whenLoaded('pegawai'))
        ];
    }
}
