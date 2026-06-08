<?php

namespace App\Http\Controllers;

use App\Models\Unit;

// Controller untuk fitur scan QR — menangani URL dari QR yang ditempel di unit alat
class ScanController extends Controller
{
    // Dipanggil saat siswa scan QR → browser buka URL /pinjam/scan/{kode_unit}
    public function formPinjam($kode)
    {
        // Cari unit berdasarkan kode_unit (bukan ID) karena itulah yang ada di QR
        // with('alat') = ambil data alat juga sekaligus (untuk tampilkan nama & foto)
        $unit = Unit::with('alat')
            ->where('kode_unit', $kode)
            ->first(); // first() = ambil satu data, null kalau tidak ada

        // Kode tidak ditemukan di database → tampilkan halaman error
        if (!$unit) {
            return view('scan.tidak_ditemukan', ['kode' => $kode]);
        }

        // Unit ditemukan tapi tidak tersedia → tampilkan halaman error
        if ($unit->status !== 'Tersedia') {
            return view('scan.tidak_tersedia', ['unit' => $unit]);
        }

        // Unit ditemukan dan tersedia → tampilkan form konfirmasi pinjam
        return view('scan.form_pinjam', ['unit' => $unit]);
    }
}
