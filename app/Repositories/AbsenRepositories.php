<?php

namespace App\Repositories;

use App\Interfaces\AbsenInterface;
use App\Models\Absensi;
use App\Models\Lokasi;
use App\Models\Pegawai;
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
        return $this->absensi->with('pegawai', 'lokasi')->get();
    }

    public function getById(string $id):?Absensi
    {
        return $this->absensi->with('pegawai', 'lokasi')->find($id);
    }

    public function create(array $data): Absensi
    {
        if(!Pegawai::find($data['pegawai_id'])){ 
            throw new \Exception('Pegawai Tidak Ditemukan', 404);
        }
        if(!Lokasi::find($data['lokasi_id'])){
            throw new \Exception('Lokasi Tidak Ditemukan', 404);
        }
        if (!$this->validateLocation($data['lokasi_gps'], $data['lokasi_id'])) {
            throw new \Exception('Lokasi Tidak Sesuai', 404);
        }
        return $this->absensi->create($data);
    }

    public function update(string $id, array $data):?Absensi
    {
        $absensi = $this->getById($id);
        if ($absensi) {
            if (!Pegawai::find($data['pegawai_id'])) {
                throw new \Exception('Pegawai Tidak Ditemukan', 404);
            }
            if(!Lokasi::find($data['lokasi_id'])){
                throw new \Exception('Lokasi Tidak Ditemukan', 404);
            }
            if (!$this->validateLocation($data['lokasi_gps'], $data['lokasi_id'])) {
                throw new \Exception('Lokasi Tidak Sesuai', 404);
            }


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

    private function validateLocation(string $lokasiGps, string $lokasiId): bool
    {
        $lokasi = Lokasi::find($lokasiId);
        if(!$lokasi){
            return false;
        }
        // string lokasi gps
        $lokasiGps = explode(',', $lokasiGps);
        $latitude = floatval($lokasiGps[0]);
        $longitude = floatval($lokasiGps[1]);

        // Hitung jarak antara lokasi GPS dan lokasi di database
        $jarak = $this->haversineGreatCircleDistance($latitude, $longitude, $lokasi->latitude, $lokasi->longitude);
        return $jarak <= $lokasi->radius_validasi;
    }

    // Fungsi untuk menghitung jarak menggunakan rumus Haversine
    private function haversineGreatCircleDistance(float $latitudeFrom, float $longitudeFrom, float $latitudeTo, float $longitudeTo): float
    {
        // Konversi derajat ke radian
        $latitudeFrom = deg2rad($latitudeFrom);
        $longitudeFrom = deg2rad($longitudeFrom);
        $latitudeTo = deg2rad($latitudeTo);
        $longitudeTo = deg2rad($longitudeTo);

        // Hitung perbedaan latitude dan longitude
        $latitudeDiff = $latitudeTo - $latitudeFrom;
        $longitudeDiff = $longitudeTo - $longitudeFrom;

        // Hitung jarak menggunakan rumus Haversine
        $a = sin($latitudeDiff / 2) * sin($latitudeDiff / 2) +
            cos($latitudeFrom) * cos($latitudeTo) *
            sin($longitudeDiff / 2) * sin($longitudeDiff / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        // Radius bumi dalam meter
        $earthRadius = 6371000;

        // Hitung jarak dalam meter
        return $earthRadius * $c;
    }
}