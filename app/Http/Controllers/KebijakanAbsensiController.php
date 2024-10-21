<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass;
use App\Http\Requests\KebijakanAbsensiRequest;
use App\Http\Resources\KebijakamAbsensiResource;
use App\Interfaces\KebijakanAbsensiInterface;
use App\Models\kebijakan_absensi;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KebijakanAbsensiController extends Controller
{
    private $kebijakanAbsensiRepository;

    public function __construct(KebijakanAbsensiInterface $kebijakanAbsensi)
    {
        $this->kebijakanAbsensiRepository = $kebijakanAbsensi;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $data = $this->kebijakanAbsensiRepository->getAll();
            return ApiResponseClass::sendResponse(
                KebijakamAbsensiResource::collection($data), 
                "Data Kebijakan Absensi Berhasil Diambil", 
                200
            );
        } catch (Exception $e) {
            Log::error('Error fetching kebijakan absensi data: ' . $e->getMessage());
            return ApiResponseClass::sendError(
                null,
                'Gagal mengambil data kebijakan absensi',
                500
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param KebijakanAbsensiRequest $request
     * @return JsonResponse
     */
    public function store(KebijakanAbsensiRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $kebijakanAbsensi = $this->kebijakanAbsensiRepository->create($request->validated());
            DB::commit();
            return ApiResponseClass::sendResponse(
                new KebijakamAbsensiResource($kebijakanAbsensi), 
                'Data Kebijakan Absensi Berhasil Ditambahkan', 
                201
            );
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error storing kebijakan absensi: ' . $e->getMessage(), [
                'request' => $request->validated(),
                'error' => $e
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Data Kebijakan Absensi Gagal Ditambahkan',
                'error' => $e->getMessage()
            ], 500);
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
            $kebijakanAbsensi = $this->kebijakanAbsensiRepository->getById($id);
            
            if (!$kebijakanAbsensi) {
                return ApiResponseClass::sendError(
                    'Data kebijakan absensi tidak ditemukan', 
                    null
                );
            }
            
            return ApiResponseClass::sendResponse(
                new KebijakamAbsensiResource($kebijakanAbsensi), 
                "Data Kebijakan Absensi Ditemukan", 
                200
            );
        } catch (Exception $e) {
            Log::error('Error fetching kebijakan absensi: ' . $e->getMessage(), [
                'id' => $id,
                'error' => $e
            ]);
            
            return ApiResponseClass::sendError(
                null,
                'Gagal mengambil data kebijakan absensi',
                500
            );
        }
    }

    public function update(KebijakanAbsensiRequest $request, string $id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $kebijakanAbsensi = $this->kebijakanAbsensiRepository->getById($id);
            if (!$kebijakanAbsensi) {
                return ApiResponseClass::sendResponse(
                    null, 
                    'Data kebijakan absensi tidak ditemukan', 
                    404
                );
            }
            $kebijakanAbsensi = $this->kebijakanAbsensiRepository->update($id, $request->validated());
            DB::commit();
            return ApiResponseClass::sendResponse(
                new KebijakamAbsensiResource($kebijakanAbsensi), 
                'Data Kebijakan Absensi Berhasil Diupdate', 
                200
            );
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error updating kebijakan absensi: ' . $e->getMessage(), [
                'id' => $id,
                'request' => $request->validated(),
                'error' => $e
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Data Absen Gagal Ditambahkan',
                'error' => $e->getMessage()
            ], 500);
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
            $kebijakanAbsensi = $this->kebijakanAbsensiRepository->getById($id);
            if (!$kebijakanAbsensi) {
                return ApiResponseClass::sendResponse(
                    null, 
                    'Data kebijakan absensi tidak ditemukan', 
                    404
                );
            }

            $this->kebijakanAbsensiRepository->delete($id);
            
            return ApiResponseClass::sendResponse(
                null, 
                'Data Kebijakan Absensi Berhasil Dihapus', 
                200
            );
        } catch (Exception $e) {
            Log::error('Error deleting kebijakan absensi: ' . $e->getMessage(), [
                'id' => $id,
                'error' => $e
            ]);
            
            return ApiResponseClass::sendError(
                null,
                'Data Kebijakan Absensi Gagal Dihapus',
                500
            );
        }
    }
}
