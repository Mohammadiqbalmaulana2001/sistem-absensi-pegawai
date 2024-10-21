<?php

namespace App\Interfaces;

use App\Models\kebijakan_absensi;
use Illuminate\Database\Eloquent\Collection;

interface KebijakanAbsensiInterface
{
    public function getAll(): Collection;
    public function getById(string $id):?kebijakan_absensi;
    public function create(array $data): kebijakan_absensi;
    public function update(string $id, array $data):?kebijakan_absensi;
    public function delete(string $id): bool;
}
