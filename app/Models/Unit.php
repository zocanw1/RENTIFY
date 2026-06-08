<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = ['alat_id', 'kode_unit', 'foto', 'status'];

    public function alat()
    {
        return $this->belongsTo(Alat::class);
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }

    // Helper: apakah unit ini bisa dipinjam
    public function bisa_dipinjam(): bool
    {
        return $this->status === 'Tersedia';
    }
}
