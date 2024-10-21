<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KebijakanAbsensiRequest extends FormRequest
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
            'jam_masuk_normal' => ['required', 'date_format:H:i:s'],
            'jam_pulang_normal' => ['required', 'date_format:H:i:s', 'after:jam_masuk_normal'],
            'batas_keterlambatan_menit' => ['required', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'jam_masuk_normal.required' => 'Jam masuk normal wajib diisi',
            'jam_masuk_normal.date_format' => 'Format jam masuk normal harus H:i:s',
            'jam_pulang_normal.required' => 'Jam pulang normal wajib diisi',
            'jam_pulang_normal.date_format' => 'Format jam pulang normal harus H:i:s',
            'jam_pulang_normal.after' => 'Jam pulang harus setelah jam masuk',
            'batas_keterlambatan_menit.required' => 'Batas keterlambatan menit wajib diisi',
            'batas_keterlambatan_menit.integer' => 'Batas keterlambatan menit harus berupa angka',
            'batas_keterlambatan_menit.min' => 'Batas keterlambatan menit harus lebih dari 0',
        ];
    }
}
