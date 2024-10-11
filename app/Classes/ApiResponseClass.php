<?php

namespace App\Classes;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ApiResponseClass
{
    
    public static function rollback($e,$message='Ada yang tidak beress! Proses belum selesai')
    {
        DB::rollBack();
        self::throw($e, $message);
    }

    public static function throw($e,$message='Ada yang tidak beress! Proses gagal')
    {
        Log::info($e);
        throw new HttpResponseException(response()->json([
            'message' => $message
        ], 500));
    }
    public static function sendResponse($result, $message, $code = 200)
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data'    => $result,
        ];
        if (!empty($message)) {
            $response['message'] = $message;
        }
        return response()->json($response, $code);
    }
}
