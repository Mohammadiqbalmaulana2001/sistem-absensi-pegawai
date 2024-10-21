<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass;
use App\Http\Requests\KameraRequest;
use App\Http\Resources\KameraResource;
use App\Interfaces\KameraInterface;
use App\Models\Kamera;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KameraController extends Controller
{
    private $kameraRepository;
    public function __construct(KameraInterface $kameraInterface)
    {
        $this->kameraRepository = $kameraInterface;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $data = $this->kameraRepository->getAll();
            return ApiResponseClass::sendResponse(
                KameraResource::collection($data), 
                "Data Kamera Berhasil Diambil", 
                200
            );
        } catch (Exception $e) {
            Log::error('Error fetching kamera data: ' . $e->getMessage());
            return ApiResponseClass::sendError(
                null,
                'Gagal mengambil data kamera',
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
    public function store(KameraRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $kamera = $this->kameraRepository->create($request->validated());
            DB::commit();
            return ApiResponseClass::sendResponse(
                new KameraResource($kamera), 
                'Data Kamera Berhasil Ditambahkan', 
                201
            );
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error storing kamera: ' . $e->getMessage(), [
                'request' => $request->validated(),
                'error' => $e
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Data Kamera Gagal Ditambahkan',
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
            $kamera = $this->kameraRepository->getById($id);
            
            if (!$kamera) {
                return ApiResponseClass::sendError(
                    'Data kamera tidak ditemukan', 
                    null
                );
            }
            
            return ApiResponseClass::sendResponse(
                new KameraResource($kamera), 
                "Data Kamera Ditemukan", 
                200
            );
        } catch (Exception $e) {
            Log::error('Error fetching kamera: ' . $e->getMessage(), [
                'id' => $id,
                'error' => $e
            ]);
            
            return ApiResponseClass::sendError(
                null,
                'Gagal mengambil data kamera',
                500
            );
        }
    }

    public function update(KameraRequest $request, string $id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $kamera = $this->kameraRepository->getById($id);
            if (!$kamera) {
                return ApiResponseClass::sendResponse(
                    null, 
                    'Data kamera tidak ditemukan', 
                    404
                );
            }
            $kamera = $this->kameraRepository->update($id, $request->validated());
            DB::commit();
            return ApiResponseClass::sendResponse(
                new KameraResource($kamera), 
                'Data Kamera Berhasil Diupdate', 
                200
            );
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error updating kamera: ' . $e->getMessage(), [
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
            $kamera = $this->kameraRepository->getById($id);
            if (!$kamera) {
                return ApiResponseClass::sendResponse(
                    null, 
                    'Data kamera tidak ditemukan', 
                    404
                );
            }

            $this->kameraRepository->delete($id);
            
            return ApiResponseClass::sendResponse(
                null, 
                'Data Kamera Berhasil Dihapus', 
                200
            );
        } catch (Exception $e) {
            Log::error('Error deleting kamera: ' . $e->getMessage(), [
                'id' => $id,
                'error' => $e
            ]);
            
            return ApiResponseClass::sendError(
                null,
                'Data Kamera Gagal Dihapus',
                500
            );
        }
    }
}
