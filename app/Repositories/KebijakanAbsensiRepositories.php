<?php

namespace App\Repositories;

use App\Interfaces\KebijakanAbsensiInterface;
use App\Models\kebijakan_absensi;
use Illuminate\Database\Eloquent\Collection;

class KebijakanAbsensiRepositories implements KebijakanAbsensiInterface
{
    public function getAll(): Collection
    {
        return kebijakan_absensi::all();
    }

    public function getById(string $id): ?kebijakan_absensi
    {
        return kebijakan_absensi::find($id);
    }

    public function create(array $data): kebijakan_absensi
    {
        return kebijakan_absensi::create($data);
    }

    public function update(string $id, array $data): ?kebijakan_absensi
    {
        $kebijakan = kebijakan_absensi::find($id);
        if ($kebijakan) {
            $kebijakan->update($data);
            $kebijakan->refresh(); 
        }
        return $kebijakan;
    }

    public function delete(string $id): bool
    {
        $kebijakan = kebijakan_absensi::find($id);
        if ($kebijakan) {
            return $kebijakan->delete();
        }
        return false;
    }
}
