<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LogAktivitasRequest extends FormRequest
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
            'pegawai_id' => 'required|uuid|exists:pegawais,id|nullable',
            'aktivitas' => 'required|string',
            'deskripsi' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'pegawai_id.uuid' => 'Pegawai tidak valid',
            'pegawai_id.exists' => 'Pegawai tidak ditemukan',
            'aktivitas.required' => 'Aktivitas tidak boleh kosong',
            'deskripsi.string' => 'Deskripsi tidak valid',
        ];
    }
}
