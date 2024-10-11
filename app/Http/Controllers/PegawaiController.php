<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass;
use App\Http\Requests\PegawaiRequest;
use App\Http\Resources\PegawaiResource;
use App\Interfaces\PegawaiInterface;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class PegawaiController extends Controller
{
    private PegawaiInterface $pegawaiInterface;
    public function __construct(PegawaiInterface $pegawaiInterface)
    {
        $this->pegawaiInterface = $pegawaiInterface;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->pegawaiInterface->index();
        return ApiResponseClass::sendResponse(PegawaiResource::collection($data), 'Data Pegawai', 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PegawaiRequest $request)
    {
        $details = [
                'nama' => $request->nama,
                'nip' => $request->nip,
                'jabatan' => $request->jabatan,
                'foto' => $request->foto,
                'email' => $request->email,
                'no_hp' => $request->no_hp
            ];
        DB::beginTransaction();
        try {
            $pegawai = $this->pegawaiInterface->store($details);
            DB::commit();
            return ApiResponseClass::sendResponse(new PegawaiResource($pegawai), 'Data Pegawai Berhasil Di Tambahkan', 200);
        } catch (\Exception $ex) {
            DB::rollBack();
            Log::error('Error storing pegawai: ' . $ex->getMessage(), [
                'request' => $request->all(),
                'error' => $ex
            ]);

            // Kembalikan response error
            return response()->json([
                'message' => 'Data Pegawai Gagal Ditambahkan',
                'error' => $ex->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pegawai = $this->pegawaiInterface->getById($id);
        if (empty($pegawai)){
            return ApiResponseClass::sendResponse(null, 'data pegawai tidak ditemukan', 404);
        }
        return ApiResponseClass::sendResponse(new PegawaiResource($pegawai), "Data Pegawai Dengan Id $id", 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pegawai $pegawai)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $details = [
            'nama' => $request->nama,
            'nip' => $request->nip,
            'jabatan' => $request->jabatan,
            'foto' => $request->foto,
            'email' => $request->email,
            'no_hp' => $request->no_hp
        ];
        DB::beginTransaction();
        try {
            $pegawai = $this->pegawaiInterface->update($details, $id);
            DB::commit();
            return ApiResponseClass::sendResponse('Data Pegawai Berhasil Di Update', 201);
        } catch (\Exception $ex) {
            DB::rollBack();
            Log::error('Error updating pegawai: ' . $ex->getMessage(), [
                'request' => 'error updating pegawai',
                'error' => $ex
            ]);
     // Kembalikan response error
    }}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->pegawaiInterface->delete($id);
        return ApiResponseClass::sendResponse('Data Pegawai Berhasil Di Hapus', 204);
    }
}
