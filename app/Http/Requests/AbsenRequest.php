<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AbsenRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'pegawai_id' => 'required|uuid|exists:pegawais,id',
            'tanggal_absensi' => 'required|date',
            'jam_masuk' => 'nullable|date_format:H:i:s',
            'jam_keluar' => 'nullable|date_format:H:i:s',
            'lokasi_gps' => 'nullable|string',
            'status' => 'required|in:hadir,izin,terlambat',
            'alasan' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'pegawai_id.required' => 'Pegawai ID harus diisi',
            'tanggal_absensi.required' => 'Tanggal Absensi harus diisi', 
            'jam_masuk.date_format' => 'Format jam masuk tidak sesuai',
            'jam_keluar.date_format' => 'Format jam keluar tidak sesuai',
            'jam_keluar.after' => 'Jam keluar harus setelah jam masuk',
            'status.required' => 'Status harus diisi',
        ];
    }
    public function failedValidator(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }
}
