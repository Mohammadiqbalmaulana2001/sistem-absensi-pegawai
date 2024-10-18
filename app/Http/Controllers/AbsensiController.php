<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass;
use App\Http\Requests\AbsenRequest;
use App\Http\Resources\AbsenResource;
use App\Interfaces\AbsenInterface;
use App\Models\Absensi;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class AbsensiController extends Controller
{
    protected $absenRepository;

    public function __construct(AbsenInterface $absenInterface)
    {
        $this->absenRepository = $absenInterface;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $data = $this->absenRepository->getAll();
            return ApiResponseClass::sendResponse(
                AbsenResource::collection($data), 
                "Data Absensi Berhasil Diambil", 
                200
            );
        } catch (Exception $e) {
            Log::error('Error fetching absensi data: ' . $e->getMessage());
            return ApiResponseClass::sendError(
                null,
                'Gagal mengambil data absensi',
                500
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AbsenRequest $request
     * @return JsonResponse
     */
    public function store(AbsenRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            
            $absen = $this->absenRepository->create($request->validated());
            
            DB::commit();
            
            return ApiResponseClass::sendResponse(
                new AbsenResource($absen), 
                'Data Absen Berhasil Ditambahkan', 
                201
            );
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error storing absen: ' . $e->getMessage(), [
                'request' => $request->validated(),
                'error' => $e
            ]);
            
            return ApiResponseClass::sendError(
                null,
                'Data Absen Gagal Ditambahkan',
                500
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        try {
            $absensi = $this->absenRepository->getById($id);
            
            if (!$absensi) {
                return ApiResponseClass::sendError(
                    'Data absensi tidak ditemukan', 
                    null
                );
            }
            
            return ApiResponseClass::sendResponse(
                new AbsenResource($absensi), 
                "Data Absensi Ditemukan", 
                200
            );
        } catch (Exception $e) {
            Log::error('Error fetching absensi: ' . $e->getMessage(), [
                'id' => $id,
                'error' => $e
            ]);
            
            return ApiResponseClass::sendError(
                null,
                'Gagal mengambil data absensi',
                500
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AbsenRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(AbsenRequest $request, string $id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $absensi = $this->absenRepository->getById($id);
            if (!$absensi) {
                return ApiResponseClass::sendResponse(
                    null, 
                    'Data absensi tidak ditemukan', 
                    404
                );
            }

            $absen = $this->absenRepository->update($id, $request->validated());
            
            DB::commit();
            
            return ApiResponseClass::sendResponse(
                new AbsenResource($absen), 
                'Data Absen Berhasil Diupdate', 
                200
            );
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error updating absen: ' . $e->getMessage(), [
                'id' => $id,
                'request' => $request->validated(),
                'error' => $e
            ]);
            
            return ApiResponseClass::sendError(
                null,
                'Data Absen Gagal Diupdate',
                500
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $absensi = $this->absenRepository->getById($id);
            if (!$absensi) {
                return ApiResponseClass::sendResponse(
                    null, 
                    'Data absensi tidak ditemukan', 
                    404
                );
            }

            $this->absenRepository->delete($id);
            
            return ApiResponseClass::sendResponse(
                null, 
                'Data Absen Berhasil Dihapus', 
                200
            );
        } catch (Exception $e) {
            Log::error('Error deleting absen: ' . $e->getMessage(), [
                'id' => $id,
                'error' => $e
            ]);
            
            return ApiResponseClass::sendError(
                null,
                'Data Absen Gagal Dihapus',
                500
            );
        }
    }
}