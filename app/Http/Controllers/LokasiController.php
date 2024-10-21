<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass;
use App\Http\Requests\LokasiRequest;
use App\Http\Resources\LokasiResource;
use App\Interfaces\LokasiInterface;
use App\Models\Lokasi;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LokasiController extends Controller
{
    private $lokasiRepository;

    public function __construct(LokasiInterface $lokasiInterface)
    {
        $this->lokasiRepository = $lokasiInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $data = $this->lokasiRepository->index();
            return ApiResponseClass::sendResponse(
                LokasiResource::collection($data), 
                "Data Lokasi Berhasil Diambil", 
                200
            );
        } catch (Exception $e) {
            Log::error('Error fetching lokasi data: ' . $e->getMessage());
            return ApiResponseClass::sendError(
                null,
                'Gagal mengambil data lokasi',
                500
            );
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LokasiRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $data = $this->lokasiRepository->store($request->validated());
            DB::commit();
            return ApiResponseClass::sendResponse(
                new LokasiResource($data), 
                'Data Lokasi Berhasil Ditambahkan', 
                201
            );
        }catch (Exception $e) {
            Log::error('Error storing lokasi: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Data Lokasi Gagal Ditambahkan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $data = $this->lokasiRepository->getById($id);
            if (!$data) {
                return ApiResponseClass::sendError(
                    'Data lokasi dengan ID ' . $id . ' tidak ditemukan', 
                    null, 
                    404
                );
            }
            return ApiResponseClass::sendResponse(
                new LokasiResource($data), 
                'Data Lokasi dengan ID ' . $id . ' Berhasil Diambil', 
                200
            );
        } catch (Exception $e) {
            Log::error('Error fetching lokasi data: ' . $e->getMessage());
            return ApiResponseClass::sendError(
                null,
                'Gagal mengambil data lokasi',
                500
            );
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lokasi $lokasi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LokasiRequest $request, string $id): JsonResponse
    {
        try {
            DB::beginTransaction();
            $data = $this->lokasiRepository->update($request->validated(), $id);
            DB::commit();
            return ApiResponseClass::sendResponse(
                new LokasiResource($data), 
                'Data Lokasi Berhasil Diupdate', 
                200
            );
        } catch (Exception $e) {
            Log::error('Error updating lokasi: ' . $e->getMessage(), [
                'request' => $request->validated(),
                'error' => $e
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Data Lokasi Gagal Diupdate',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $lokasi = $this->lokasiRepository->getById($id);
            if (!$lokasi) {
                return ApiResponseClass::sendResponse(
                    null, 
                    'Data lokasi tidak ditemukan', 
                    404
                );
            }
            $this->lokasiRepository->delete($id);
            return ApiResponseClass::sendResponse(
                null, 
                'Data Lokasi Berhasil Dihapus', 
                200
            );
        } catch (Exception $e) {
            Log::error('Error deleting lokasi: ' . $e->getMessage(), [
                'error' => $e
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Data Lokasi Gagal Dihapus',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
