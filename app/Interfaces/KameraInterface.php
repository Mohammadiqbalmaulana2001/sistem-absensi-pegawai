<?php

namespace App\Interfaces;

use App\Models\Kamera;
use Illuminate\Database\Eloquent\Collection;

interface KameraInterface
{
    public function getAll(): Collection;
    public function getById(string $id):?Kamera;
    public function create(array $data): Kamera;
    public function update(string $id, array $data):?Kamera;
    public function delete(string $id): bool;
}
