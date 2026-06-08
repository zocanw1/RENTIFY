<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $fotoRules = $this->isMethod('POST')
            ? ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048']
            : ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'];

        $rules = [
            'nama_alat'   => ['required', 'string', 'max:100'],
            'foto'        => $fotoRules,
        ];

        // Saat tambah: jumlah unit wajib minimal 1
        if ($this->isMethod('POST')) {
            $rules['jumlah_unit'] = ['required', 'integer', 'min:1', 'max:100'];
            $rules['prefix_unit'] = ['required', 'string', 'max:20', 'alpha_dash'];
        } else {
            $rules['tambah_unit'] = ['nullable', 'integer', 'min:0', 'max:100'];
            $rules['prefix_unit'] = ['nullable', 'string', 'max:20'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'nama_alat.required'   => 'Nama alat wajib diisi.',
            'nama_alat.max'        => 'Nama alat maksimal 100 karakter.',
            'foto.required'        => 'Foto alat wajib diupload.',
            'foto.image'           => 'File harus berupa gambar.',
            'foto.mimes'           => 'Format foto harus jpg, jpeg, png, atau webp.',
            'foto.max'             => 'Ukuran foto maksimal 2MB.',
            'jumlah_unit.required' => 'Jumlah unit wajib diisi.',
            'jumlah_unit.min'      => 'Minimal 1 unit.',
            'jumlah_unit.max'      => 'Maksimal 100 unit.',
            'prefix_unit.required' => 'Prefix kode unit wajib diisi.',
            'prefix_unit.alpha_dash' => 'Prefix hanya boleh huruf, angka, dan tanda hubung.',
        ];
    }
}
