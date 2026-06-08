<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KembalikanRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Pastikan peminjaman ini milik user yang login
        $pinjaman = \App\Models\Peminjaman::find($this->route('peminjamanId'));
        return $pinjaman && $pinjaman->user_id === auth()->id() && $pinjaman->status_pengajuan === 'aktif';
    }

    public function rules(): array
    {
        return [
            'komentar_siswa' => ['nullable', 'string', 'max:500'],
        ];
    }
}
