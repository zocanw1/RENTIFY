<?php
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $fillable = [
        'user_id','unit_id','status_pengajuan',
        'waktu_pinjam','waktu_kembali',
        'komentar_siswa','balasan_admin',
    ];

    protected $casts = [
        'waktu_pinjam'  => 'datetime',
        'waktu_kembali' => 'datetime',
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function unit() { return $this->belongsTo(Unit::class); }

    public function masihDipinjam(): bool
    {
        return is_null($this->waktu_kembali);
    }

    /**
     * Cek apakah peminjaman ini sudah terlambat.
     * Terlambat = masih aktif DAN sudah lewat jam batas hari ini
     * atau dipinjam kemarin/sebelumnya dan belum dikembalikan.
     */
    public function isTerlambat(): bool
    {
        if ($this->status_pengajuan === 'selesai') return false;

        $batasJam = Setting::get('batas_jam_kembali', '15:00');
        [$jam, $menit] = explode(':', $batasJam);

        $batasPinjam = $this->waktu_pinjam->copy()
            ->setTime((int)$jam, (int)$menit, 0);

        // Terlambat jika sekarang sudah lewat batas waktu pada hari pinjam
        // ATAU dipinjam hari sebelumnya (belum dikembalikan sampai esok hari)
        return now()->gt($batasPinjam);
    }

    /**
     * Berapa jam/menit terlambat
     */
    public function durasiTerlambat(): string
    {
        if (!$this->isTerlambat()) return '';

        $batasJam = Setting::get('batas_jam_kembali', '15:00');
        [$jam, $menit] = explode(':', $batasJam);

        $batas = $this->waktu_pinjam->copy()->setTime((int)$jam, (int)$menit, 0);

        // Jika dipinjam beda hari, hitung dari hari pinjam
        $diff = now()->diff($batas);
        $total = now()->diffInMinutes($batas);

        if ($total < 60) return $total . ' menit';
        $jam   = intdiv($total, 60);
        $sisa  = $total % 60;
        return $jam . ' jam' . ($sisa > 0 ? ' ' . $sisa . ' menit' : '');
    }
}
