<?php

namespace App\Repositories;

use App\Interfaces\LokasiInterface;
use App\Models\Lokasi;
use Illuminate\Database\Eloquent\Collection;

class LokasiRepositories implements LokasiInterface
{
    public function index(): Collection
    {
        return Lokasi::with('absensi', 'kameras')->get();
    }
    public function getById( $id)
    {
        return Lokasi::with('absensi', 'kameras')->find($id);
    }
    public function store(array $data)
    {
        return Lokasi::create($data);
    }
    public function update ( array $data, $id)
    {
        $lokasi = $this->getById($id);
        if ($lokasi) {
            $lokasi->update($data);
            return $lokasi;
        }
        return null;
    }   
    public function delete( $id)
    {   
        $lokasi = $this->getById($id);
        if ($lokasi) {
            $lokasi->delete();
        }
    }
}
