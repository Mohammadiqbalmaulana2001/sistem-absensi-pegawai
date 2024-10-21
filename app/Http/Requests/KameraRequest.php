<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KameraRequest extends FormRequest
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
            'tipe_kamera' => ['required', 'string', 'max:255'],
            'perangkat' => ['required', 'string', 'max:255'],
            'status_kamera' => ['required', 'boolean'],
            'lokasi_id' => ['required', 'uuid', 'exists:lokasis,id'],
        ];
    }
    public function messages(): array
    {
        return [
            'tipe_kamera.required' => 'Tipe kamera harus diisi',
            'perangkat.required' => 'Perangkat harus diisi',
            'status_kamera.required' => 'Status kamera harus diisi',
            'lokasi_id.required' => 'Lokasi harus diisi',
        ];
    }
}
