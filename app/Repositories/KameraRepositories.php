<?php

namespace App\Repositories;

use App\Interfaces\KameraInterface;
use App\Models\Kamera;
use Illuminate\Database\Eloquent\Collection;

class KameraRepositories implements KameraInterface
{
    protected $kamera;

    public function __construct(Kamera $kamera)
    {
        $this->kamera = $kamera;
    }

    public function getAll(): Collection
    {
        return $this->kamera->with('lokasi')->get();
    }

    public function getById(string $id):?Kamera
    {
        return $this->kamera->with('lokasi')->find($id);
    }

    public function create(array $data): Kamera
    {
        return $this->kamera->create($data);
    }

    public function update(string $id, array $data):?Kamera
    {
        $kamera = $this->getById($id);
        if ($kamera) {
            $kamera->update($data);
            return $kamera;
        }
        return null;
    }

    public function delete(string $id): bool
    {
        $kamera = $this->getById($id);
        if ($kamera) {
            return $kamera->delete();
        }
        return false;
    }
}
