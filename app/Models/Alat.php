<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Model untuk tabel 'alats' — mewakili jenis alat (contoh: Access Point, Switch)
class Alat extends Model
{
    // Kolom yang boleh diisi lewat create() atau update()
    protected $fillable = ['nama_alat', 'foto'];

    // Satu alat punya banyak unit fisik
    public function units()
    {
        return $this->hasMany(Unit::class);
    }

    // Semua peminjaman dari alat ini (lewat tabel units)
    public function peminjaman()
    {
        return $this->hasManyThrough(
            \App\Models\Peminjaman::class,
            \App\Models\Unit::class
        );
    }

    // Helper: hitung berapa unit yang statusnya 'Tersedia'
    public function stokTersedia()
    {
        return $this->units()->where('status', 'Tersedia')->count();
    }
}
