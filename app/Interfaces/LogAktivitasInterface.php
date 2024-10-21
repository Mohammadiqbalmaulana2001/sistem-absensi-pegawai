<?php

namespace App\Interfaces;

use App\Models\log_aktivitas;
use Illuminate\Database\Eloquent\Collection;

interface LogAktivitasInterface
{
    public function getAll(): Collection;
    public function getById(string $id):?log_aktivitas;
    public function create(array $data): log_aktivitas;
    public function update(string $id, array $data):?log_aktivitas;
    public function delete(string $id): bool;
}
