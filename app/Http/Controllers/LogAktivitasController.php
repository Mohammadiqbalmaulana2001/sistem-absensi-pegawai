<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass;
use App\Http\Requests\LogAktivitasRequest;
use App\Http\Resources\LogAktivitasResource;
use App\Interfaces\LogAktivitasInterface;
use App\Models\log_aktivitas;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LogAktivitasController extends Controller
{
    private $log_aktivitas;
    public function __construct(LogAktivitasInterface $log_aktivitas)
    {
        $this->log_aktivitas = $log_aktivitas;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $data = $this->log_aktivitas->getAll();
            return ApiResponseClass::sendResponse(
                LogAktivitasResource::collection($data), 
                "Data Log Aktivitas Berhasil Diambil", 
                200
            );
        } catch (Exception $e) {
            Log::error('Error fetching log aktivitas data: ' . $e->getMessage());
            return ApiResponseClass::sendError(
                null,
                'Gagal mengambil data log aktivitas',
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
    public function store(LogAktivitasRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $data = $this->log_aktivitas->create($request->validated());
            DB::commit();
            return ApiResponseClass::sendResponse(
                new LogAktivitasResource($data), 
                'Data Log Aktivitas Berhasil Ditambahkan', 
                201
            );
        }catch (Exception $e) {
            Log::error('Error storing log aktivitas: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Data Log Aktivitas Gagal Ditambahkan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $data = $this->log_aktivitas->getById($id);
            if (!$data) {
                return ApiResponseClass::sendError(
                    'Data log aktivitas dengan ID ' . $id . ' tidak ditemukan', 
                    null, 
                    404
                );
            }
            return ApiResponseClass::sendResponse(
                new LogAktivitasResource($data), 
                'Data log aktivitas dengan ID ' . $id . ' Berhasil Diambil', 
                200
            );
        } catch (Exception $e) {
            Log::error('Error fetching log aktivitas data: ' . $e->getMessage());
            return ApiResponseClass::sendError(
                null,
                'Gagal mengambil data log aktivitas',
                500
            );
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LogAktivitasRequest $request, string $id): JsonResponse
    {
        try {
            DB::beginTransaction();
            $data = $this->log_aktivitas->update($id, $request->validated());
            DB::commit();
            return ApiResponseClass::sendResponse(
                new LogAktivitasResource($data), 
                'Data Log Aktivitas Berhasil Diupdate', 
                200
            );
        } catch (Exception $e) {
            Log::error('Error updating log aktivitas: ' . $e->getMessage(), [
                'request' => $request->validated(),
                'error' => $e
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Data Log Aktivitas Gagal Diupdate',
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
            $lokasi = $this->log_aktivitas->getById($id);
            if (!$lokasi) {
                return ApiResponseClass::sendResponse(
                    null, 
                    'Data log aktivitas tidak ditemukan', 
                    404
                );
            }
            $this->log_aktivitas->delete($id);
            return ApiResponseClass::sendResponse(
                null, 
                'Data Log Aktivitas Berhasil Dihapus', 
                200
            );
        } catch (Exception $e) {
            Log::error('Error deleting log aktivitas: ' . $e->getMessage(), [
                'error' => $e
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Data Log Aktivitas Gagal Dihapus',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
