<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\Unit;
use App\Models\User;
use Carbon\CarbonInterface;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_alat' => Alat::count(),
            'total_unit' => Unit::count(),
            'unit_tersedia' => Unit::where('status', 'Tersedia')->count(),
            'unit_dipinjam' => Unit::where('status', 'Dipinjam')->count(),
            'unit_rusak' => Unit::where('status', 'Rusak')->count(),
            'unit_diperbaiki' => Unit::where('status', 'Diperbaiki')->count(),
            'total_peminjaman' => Peminjaman::count(),
            'peminjaman_aktif' => Peminjaman::where('status_pengajuan', 'aktif')->count(),
            'menunggu_konfirmasi' => Peminjaman::where('status_pengajuan', 'menunggu_konfirmasi')->count(),
            'total_siswa' => User::where('role', 'siswa')->count(),
        ];

        $menungguKonfirmasi = Peminjaman::where('status_pengajuan', 'menunggu_konfirmasi')
            ->with(['user', 'unit.alat'])
            ->latest()
            ->get();

        $peminjamanAktif = Peminjaman::where('status_pengajuan', 'aktif')
            ->with(['user', 'unit.alat'])
            ->latest()
            ->get();

        $riwayatTerbaru = Peminjaman::where('status_pengajuan', 'selesai')
            ->with(['user', 'unit.alat'])
            ->latest('waktu_kembali')
            ->limit(5)
            ->get();

        $alatPopuler = Alat::withCount('peminjaman')
            ->orderByDesc('peminjaman_count')
            ->limit(5)
            ->get();

        [$labelBulan, $dataPinjam] = $this->buildWeeklyLoanChart();

        $statusUnit = [
            'Tersedia' => $stats['unit_tersedia'],
            'Dipinjam' => $stats['unit_dipinjam'],
            'Diperbaiki' => $stats['unit_diperbaiki'],
            'Rusak' => $stats['unit_rusak'],
        ];

        $topAlat = Alat::withCount('peminjaman')
            ->orderByDesc('peminjaman_count')
            ->limit(8)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'menungguKonfirmasi',
            'peminjamanAktif',
            'riwayatTerbaru',
            'alatPopuler',
            'labelBulan',
            'dataPinjam',
            'statusUnit',
            'topAlat'
        ));
    }

    public function konfirmasiKembali(Request $request, $peminjamanId)
    {
        $pinjaman = Peminjaman::where('status_pengajuan', 'menunggu_konfirmasi')->findOrFail($peminjamanId);
        $pinjaman->update([
            'waktu_kembali' => now(),
            'status_pengajuan' => 'selesai',
            'balasan_admin' => $request->balasan_admin,
        ]);
        $pinjaman->unit->update(['status' => 'Tersedia']);

        ActivityLog::catat(
            'konfirmasi_kembali',
            'Konfirmasi pengembalian ' . $pinjaman->unit->alat->nama_alat . ' dari ' . $pinjaman->user->name,
            'Peminjaman',
            $pinjaman->id
        );

        return redirect()->route('admin.dashboard')
            ->with('success', 'Pengembalian ' . $pinjaman->unit->alat->nama_alat . ' dikonfirmasi!');
    }

    public function statistik()
    {
        [$labelBulan, $dataPinjam] = $this->buildWeeklyLoanChart();

        $topAlat = Alat::withCount('peminjaman')
            ->orderByDesc('peminjaman_count')
            ->limit(10)
            ->get();

        $topSiswa = User::where('role', 'siswa')
            ->withCount('peminjaman')
            ->orderByDesc('peminjaman_count')
            ->limit(10)
            ->get();

        $statusUnit = [
            'Tersedia' => Unit::where('status', 'Tersedia')->count(),
            'Dipinjam' => Unit::where('status', 'Dipinjam')->count(),
            'Diperbaiki' => Unit::where('status', 'Diperbaiki')->count(),
            'Rusak' => Unit::where('status', 'Rusak')->count(),
        ];

        $perKelas = Peminjaman::join('users', 'users.id', '=', 'peminjamen.user_id')
            ->selectRaw('users.kelas, COUNT(*) as total')
            ->whereNotNull('users.kelas')
            ->groupBy('users.kelas')
            ->orderByDesc('total')
            ->get();

        $ringkasan = [
            'total_peminjaman' => Peminjaman::count(),
            'bulan_ini' => Peminjaman::whereMonth('waktu_pinjam', now()->month)
                ->whereYear('waktu_pinjam', now()->year)
                ->count(),
            'rata_durasi' => $this->averageLoanDurationHours(),
            'total_siswa_aktif' => Peminjaman::where('status_pengajuan', 'aktif')
                ->distinct('user_id')
                ->count('user_id'),
        ];

        return view('admin.statistik', compact(
            'labelBulan',
            'dataPinjam',
            'topAlat',
            'topSiswa',
            'statusUnit',
            'perKelas',
            'ringkasan'
        ));
    }

    public function exportPdf(Request $request)
    {
        $bulan = $request->bulan ?? now()->format('Y-m');
        $tahun = $request->tahun ?? now()->year;
        $filter = $request->filter ?? 'bulan';
        $query = Peminjaman::with(['user', 'unit.alat'])->orderBy('waktu_pinjam', 'desc');

        if ($filter === 'bulan') {
            [$y, $m] = explode('-', $bulan);
            $query->whereYear('waktu_pinjam', $y)->whereMonth('waktu_pinjam', $m);
            $judulPeriode = \Carbon\Carbon::parse($bulan)->translatedFormat('F Y');
        } elseif ($filter === 'tahun') {
            $query->whereYear('waktu_pinjam', $tahun);
            $judulPeriode = 'Tahun ' . $tahun;
        } else {
            $judulPeriode = 'Semua Data';
        }

        $peminjaman = $query->get();
        $stats = [
            'total' => $peminjaman->count(),
            'selesai' => $peminjaman->where('status_pengajuan', 'selesai')->count(),
            'aktif' => $peminjaman->where('status_pengajuan', 'aktif')->count(),
            'menunggu' => $peminjaman->where('status_pengajuan', 'menunggu_konfirmasi')->count(),
        ];

        return view('admin.laporan-pdf', compact('peminjaman', 'stats', 'judulPeriode', 'filter', 'bulan', 'tahun'));
    }

    public function activityLog(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        if ($request->filled('cari')) {
            $q = $request->cari;
            $query->where(fn ($s) => $s->where('keterangan', 'like', "%$q%")
                ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%$q%")));
        }

        if ($request->filled('aksi')) {
            $query->where('aksi', $request->aksi);
        }

        $logs = $query->paginate(30)->withQueryString();
        $aksiList = ActivityLog::distinct()->pluck('aksi')->sort()->values();

        return view('admin.activity-log', compact('logs', 'aksiList'));
    }

    public function laporanAlat(Alat $alat)
    {
        $alat->load('units');

        $peminjaman = Peminjaman::whereHas('unit', fn ($q) => $q->where('alat_id', $alat->id))
            ->with(['user', 'unit'])
            ->latest()
            ->get();

        $stats = [
            'total' => $peminjaman->count(),
            'selesai' => $peminjaman->where('status_pengajuan', 'selesai')->count(),
            'aktif' => $peminjaman->where('status_pengajuan', 'aktif')->count(),
            'peminjam' => $peminjaman->pluck('user_id')->unique()->count(),
        ];

        return view('admin.laporan-alat', compact('alat', 'peminjaman', 'stats'));
    }

    protected function buildWeeklyLoanChart(): array
    {
        $rangeStart = now()->subWeeks(3)->startOfWeek();

        $weeklyCounts = Peminjaman::where('waktu_pinjam', '>=', $rangeStart)
            ->get(['waktu_pinjam'])
            ->groupBy(fn (Peminjaman $loan) => $loan->waktu_pinjam->copy()->startOfWeek()->format('oW'))
            ->map->count();

        $labels = [];
        $series = [];

        for ($i = 3; $i >= 0; $i--) {
            $weekStart = now()->subWeeks($i)->startOfWeek();
            $weekKey = $weekStart->format('oW');

            $labels[] = $this->formatWeekLabel($weekStart);
            $series[] = $weeklyCounts[$weekKey] ?? 0;
        }

        return [$labels, $series];
    }

    protected function formatWeekLabel(CarbonInterface $weekStart): string
    {
        return $weekStart->format('d M') . ' - ' . $weekStart->copy()->endOfWeek()->format('d M');
    }

    protected function averageLoanDurationHours(): int
    {
        $durations = Peminjaman::whereNotNull('waktu_kembali')
            ->get(['waktu_pinjam', 'waktu_kembali'])
            ->map(fn (Peminjaman $loan) => $loan->waktu_pinjam->diffInMinutes($loan->waktu_kembali) / 60)
            ->filter(fn (float $hours) => $hours >= 0);

        if ($durations->isEmpty()) {
            return 0;
        }

        return (int) round($durations->avg());
    }
}
