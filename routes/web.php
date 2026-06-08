<?php
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RiwayatAdminController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'landing');

Route::get('/pinjam/scan/{kode}', [ScanController::class,'formPinjam'])->middleware('auth')->name('scan.form');
Route::get('/scan/kamera', fn() => view('scan.kamera'))->middleware('auth')->name('scan.kamera');

// ─── Siswa & Semua Role ────────────────────────────────────
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard',  [DashboardController::class,'index'])->name('dashboard');
    Route::get('/pinjam/{id}',[DashboardController::class,'detail'])->name('pinjam.detail');
    Route::post('/proses-pinjam/{unitId}',[DashboardController::class,'prosesPinjam'])->name('pinjam.proses');
    Route::get('/riwayat',    [DashboardController::class,'riwayat'])->name('riwayat');
    Route::post('/kembalikan/{peminjamanId}',[DashboardController::class,'kembalikan'])->name('pinjam.kembalikan');

    Route::get('/profile',          [ProfileController::class,'edit'])->name('profile.edit');
    Route::patch('/profile',        [ProfileController::class,'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class,'updatePassword'])->name('profile.password');
    Route::delete('/profile',       [ProfileController::class,'destroy'])->name('profile.destroy');
});

// ─── Admin ─────────────────────────────────────────────────
Route::middleware(['auth','admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class,'dashboard'])->name('admin.dashboard');
    Route::post('/admin/konfirmasi-kembali/{id}',[AdminController::class,'konfirmasiKembali'])->name('admin.konfirmasi.kembali');

    // Statistik & Laporan
    Route::get('/admin/statistik',     [AdminController::class,'statistik'])->name('admin.statistik');
    Route::get('/admin/laporan-pdf',   [AdminController::class,'exportPdf'])->name('admin.laporan.pdf');
    Route::get('/admin/laporan-excel', [RiwayatAdminController::class,'exportExcel'])->name('admin.riwayat.excel');
    Route::get('/admin/laporan-alat/{alat}', [AdminController::class,'laporanAlat'])->name('admin.laporan.alat');

    // Log aktivitas
    Route::get('/admin/activity-log',  [AdminController::class,'activityLog'])->name('admin.activity.log');

    // Riwayat
    Route::get('/admin/riwayat',                [RiwayatAdminController::class,'index'])->name('admin.riwayat.index');
    Route::get('/admin/riwayat/siswa/{user}',          [RiwayatAdminController::class,'siswa'])->name('admin.riwayat.siswa');
    Route::get('/admin/riwayat/siswa/{user}/pdf',      [RiwayatAdminController::class,'siswaPdf'])->name('admin.riwayat.siswa.pdf');
    Route::get('/admin/riwayat/siswa/{user}/excel',    [RiwayatAdminController::class,'siswaExcel'])->name('admin.riwayat.siswa.excel');
    Route::delete('/admin/riwayat/{id}/hapus',          [RiwayatAdminController::class,'hapus'])->name('admin.riwayat.hapus');

    // Setting
    Route::get('/admin/settings',  [SettingController::class,'index'])->name('admin.settings');
    Route::post('/admin/settings', [SettingController::class,'update'])->name('admin.settings.update');

    // Alat
    Route::resource('admin/alat', AlatController::class)->names('admin.alat');
    Route::get('/admin/alat/{alat}/qr', function(\App\Models\Alat $alat) {
        $alat->load('units'); return view('admin.alat.qr',compact('alat'));
    })->name('admin.alat.qr');
    Route::get('/admin/alat/{alat}/laporan', [AdminController::class,'laporanAlat'])->name('admin.alat.laporan');

    // Unit
    Route::post('/admin/unit/{unit}/status', [AlatController::class,'updateStatusUnit'])->name('admin.unit.status');
    Route::get('/admin/unit/{unit}/edit',    [AlatController::class,'editUnit'])->name('admin.unit.edit');
    Route::put('/admin/unit/{unit}',         [AlatController::class,'updateUnit'])->name('admin.unit.update');
    Route::delete('/admin/unit/{unit}',      [AlatController::class,'destroyUnit'])->name('admin.unit.destroy');

    // Siswa
    Route::get('/admin/siswa',           [SiswaController::class,'index'])->name('admin.siswa.index');
    Route::post('/admin/siswa/import',   [SiswaController::class,'import'])->name('admin.siswa.import');
    Route::put('/admin/siswa/{user}',    [SiswaController::class,'update'])->name('admin.siswa.update');
    Route::delete('/admin/siswa/{user}', [SiswaController::class,'destroy'])->name('admin.siswa.destroy');
});

// ─── Staff ─────────────────────────────────────────────────
Route::middleware(['auth','staff'])->group(function () {
    Route::get('/staff/dashboard', [StaffController::class,'dashboard'])->name('staff.dashboard');
    Route::get('/staff/siswas',    [StaffController::class,'siswas'])->name('staff.siswas');
});

// ─── PWA ───────────────────────────────────────────────────
Route::get('/manifest.json', fn() => response()->json([
    'name'=>'TEAMS','short_name'=>'TEAMS',
    'description'=>'Sistem Peminjaman Alat Praktik SMK',
    'start_url'=>'/','display'=>'standalone',
    'background_color'=>'#f8f8fc','theme_color'=>'#4f46e5',
    'icons'=>[
        ['src'=>'/icons/icon-192.png','sizes'=>'192x192','type'=>'image/png','purpose'=>'any maskable'],
        ['src'=>'/icons/icon-512.png','sizes'=>'512x512','type'=>'image/png','purpose'=>'any maskable'],
    ],
]))->name('pwa.manifest');
Route::get('/sw.js', fn() => response()->file(public_path('sw.js'),['Content-Type'=>'application/javascript']));

require __DIR__.'/auth.php';
