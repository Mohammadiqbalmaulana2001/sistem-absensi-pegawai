<?php

namespace App\Repositories;

use App\Interfaces\AbsenInterface;
use App\Models\Absensi;
use Illuminate\Database\Eloquent\Collection;

class AbsenRepositories implements AbsenInterface
{
    protected $absensi;
    public function __construct(Absensi $absensi)
    {
        $this->absensi = $absensi;
    }

    public function getAll(): Collection
    {
        return $this->absensi->with('pegawai')->get();
    }

    public function getById(string $id):?Absensi
    {
        return $this->absensi->find($id);
    }

    public function create(array $data): Absensi
    {
        return $this->absensi->create($data);
    }

    public function update(string $id, array $data):?Absensi
    {
        $absensi = $this->getById($id);
        if ($absensi) {
            $absensi->update($data);
            return $absensi;
        }
        return null;
    }

    public function delete(string $id): bool
    {
        $absensi = $this->getById($id);
        if ($absensi) {
            return $absensi->delete();
        }
        return false;
    }
}