<?php

namespace App\Interfaces;

use App\Models\Absensi;
use Illuminate\Database\Eloquent\Collection;

interface AbsenInterface
{
    public function getAll(): Collection;
    public function getById(string $id):?Absensi;
    public function create(array $data): Absensi;
    public function update(string $id, array $data):?Absensi;
    public function delete(string $id): bool;
}
