<?php

namespace App\Http\Controllers;

use App\Http\Requests\PinjamRequest;
use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\Unit;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Halaman utama siswa — daftar semua alat
    public function index(Request $request)
    {
        $query = Alat::with('units');

        if ($request->filled('cari')) {
            $query->where('nama_alat', 'like', '%' . $request->cari . '%');
        }

        if ($request->filter === 'tersedia') {
            $query->whereHas('units', fn($q) => $q->where('status', 'Tersedia'));
        } elseif ($request->filter === 'habis') {
            $query->whereDoesntHave('units', fn($q) => $q->where('status', 'Tersedia'));
        }

        $alats = $query->get();

        return view('dashboard', compact('alats'));
    }

    // Detail alat — tampilkan semua unit & statusnya
    public function detail($id)
    {
        $alat = Alat::with('units')->findOrFail($id);
        return view('detail_alat', compact('alat'));
    }

    // Proses pinjam
    public function prosesPinjam(PinjamRequest $request, $unitId)
    {
        $unit = Unit::findOrFail($unitId);

        Peminjaman::create([
            'user_id'          => auth()->id(),
            'unit_id'          => $unit->id,
            'waktu_pinjam'     => now(),
            'status_pengajuan' => 'aktif',
        ]);

        // Status unit langsung berubah jadi Dipinjam otomatis
        $unit->update(['status' => 'Dipinjam']);

        return redirect()->route('riwayat')
            ->with('success', 'Berhasil meminjam ' . $unit->alat->nama_alat . ' (' . $unit->kode_unit . ')!');
    }

    // Siswa klik "Kembalikan" → bukan langsung selesai,
    // tapi ubah status_pengajuan jadi menunggu_konfirmasi
    public function kembalikan(Request $request, $peminjamanId)
    {
        $pinjaman = Peminjaman::where('user_id', auth()->id())
            ->where('status_pengajuan', 'aktif')
            ->findOrFail($peminjamanId);

        $komentar = $request->komentar_siswa; // boleh kosong

        $pinjaman->update([
            'status_pengajuan' => 'menunggu_konfirmasi',
            'komentar_siswa'   => $komentar,
        ]);

        return redirect()->route('riwayat')
            ->with('success', 'Pengajuan pengembalian berhasil! Menunggu konfirmasi admin.');
    }

    // Halaman riwayat siswa
    public function riwayat()
    {
        $riwayats = Peminjaman::where('user_id', auth()->id())
            ->with('unit.alat')
            ->latest()
            ->get();

        return view('riwayat', compact('riwayats'));
    }
}
