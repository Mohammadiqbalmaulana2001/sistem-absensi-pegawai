<?php

namespace App\Repositories;

use App\Interfaces\LogAktivitasInterface;
use App\Models\log_aktivitas;
use Illuminate\Database\Eloquent\Collection;

class LogAktivitasRepositories implements LogAktivitasInterface
{
    private $LogAktivitas;
    public function __construct(log_aktivitas $LogAktivitas){
        $this->LogAktivitas = $LogAktivitas;
    }

    public function getAll(): Collection
    {
        return $this->LogAktivitas->with('pegawai')->get();
    }
    public function getById(string $id):?log_aktivitas
    {
        return $this->LogAktivitas->with('pegawai')->find($id);
    }

    public function create(array $data): log_aktivitas
    {
        return $this->LogAktivitas->create($data);
    }

    public function update(string $id, array $data):?log_aktivitas
    {
        $LogAktivitas = $this->getById($id);
        if ($LogAktivitas) {
            $LogAktivitas->update($data);
            return $LogAktivitas;
        }
        return null;
    }

    public function delete(string $id): bool
    {
        $LogAktivitas = $this->getById($id);
        if ($LogAktivitas) {
            $LogAktivitas->destroy($id);
            return true;
        }
        return false;
    }
}
