<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

class InventorySeeder extends Seeder
{
    public function run(): void
    {
        if (User::where('role', 'siswa')->doesntExist()) {
            $this->call(SiswaSeeder::class);
        }

        Schema::disableForeignKeyConstraints();
        Peminjaman::query()->delete();
        ActivityLog::query()->delete();
        Unit::query()->delete();
        Alat::query()->delete();
        Schema::enableForeignKeyConstraints();

        $inventory = collect([
            [
                'nama_alat' => 'Laptop Lenovo ThinkPad',
                'units' => [
                    ['kode_unit' => 'LTP-01', 'status' => 'Dipinjam'],
                    ['kode_unit' => 'LTP-02', 'status' => 'Tersedia'],
                    ['kode_unit' => 'LTP-03', 'status' => 'Diperbaiki'],
                ],
            ],
            [
                'nama_alat' => 'Proyektor Epson',
                'units' => [
                    ['kode_unit' => 'PRO-01', 'status' => 'Dipinjam'],
                    ['kode_unit' => 'PRO-02', 'status' => 'Tersedia'],
                    ['kode_unit' => 'PRO-03', 'status' => 'Rusak'],
                ],
            ],
            [
                'nama_alat' => 'Kamera Canon DSLR',
                'units' => [
                    ['kode_unit' => 'KAM-01', 'status' => 'Dipinjam'],
                    ['kode_unit' => 'KAM-02', 'status' => 'Tersedia'],
                ],
            ],
            [
                'nama_alat' => 'Router Mikrotik',
                'units' => [
                    ['kode_unit' => 'MKT-01', 'status' => 'Dipinjam'],
                    ['kode_unit' => 'MKT-02', 'status' => 'Tersedia'],
                    ['kode_unit' => 'MKT-03', 'status' => 'Tersedia'],
                ],
            ],
            [
                'nama_alat' => 'Tang Crimping',
                'units' => [
                    ['kode_unit' => 'CRP-01', 'status' => 'Tersedia'],
                    ['kode_unit' => 'CRP-02', 'status' => 'Tersedia'],
                    ['kode_unit' => 'CRP-03', 'status' => 'Dipinjam'],
                ],
            ],
            [
                'nama_alat' => 'Multimeter Digital',
                'units' => [
                    ['kode_unit' => 'MLT-01', 'status' => 'Dipinjam'],
                    ['kode_unit' => 'MLT-02', 'status' => 'Tersedia'],
                ],
            ],
        ]);

        $units = $this->seedInventory($inventory);
        $this->seedLoans($units);
        $this->seedActivityLogs($units);
    }

    /**
     * @param  \Illuminate\Support\Collection<int, array<string, mixed>>  $inventory
     * @return \Illuminate\Support\Collection<string, \App\Models\Unit>
     */
    protected function seedInventory(Collection $inventory): Collection
    {
        $units = collect();

        foreach ($inventory as $item) {
            $alat = Alat::create([
                'nama_alat' => $item['nama_alat'],
                'foto' => null,
            ]);

            foreach ($item['units'] as $unitData) {
                $unit = $alat->units()->create([
                    'kode_unit' => $unitData['kode_unit'],
                    'foto' => null,
                    'status' => $unitData['status'],
                ]);

                $units->put($unit->kode_unit, $unit);
            }
        }

        return $units;
    }

    /**
     * @param  \Illuminate\Support\Collection<string, \App\Models\Unit>  $units
     */
    protected function seedLoans(Collection $units): void
    {
        $students = User::where('role', 'siswa')->orderBy('id')->get()->keyBy('email');
        $fallbackStudents = $students->values();

        $loanBlueprints = [
            [
                'email' => 'abdullohrezapermana@gmail.com',
                'kode_unit' => 'LTP-01',
                'status_pengajuan' => 'aktif',
                'waktu_pinjam' => now()->subHours(2),
                'waktu_kembali' => null,
                'komentar_siswa' => null,
                'balasan_admin' => null,
            ],
            [
                'email' => 'achmadrashyaadityaaffandi@gmail.com',
                'kode_unit' => 'PRO-01',
                'status_pengajuan' => 'menunggu_konfirmasi',
                'waktu_pinjam' => now()->subDay()->setTime(9, 15),
                'waktu_kembali' => null,
                'komentar_siswa' => 'Sudah selesai dipakai untuk presentasi kelas.',
                'balasan_admin' => null,
            ],
            [
                'email' => 'ainnursyifaaulia@gmail.com',
                'kode_unit' => 'KAM-01',
                'status_pengajuan' => 'selesai',
                'waktu_pinjam' => now()->subDays(2)->setTime(8, 30),
                'waktu_kembali' => now()->subDays(2)->setTime(12, 45),
                'komentar_siswa' => 'Dipakai dokumentasi kegiatan jurusan.',
                'balasan_admin' => 'Pengembalian diterima, alat aman.',
            ],
            [
                'email' => 'alfinyusufanugrah@gmail.com',
                'kode_unit' => 'MKT-01',
                'status_pengajuan' => 'aktif',
                'waktu_pinjam' => now()->subHours(5),
                'waktu_kembali' => null,
                'komentar_siswa' => null,
                'balasan_admin' => null,
            ],
            [
                'email' => 'alfirafifirimadhina@gmail.com',
                'kode_unit' => 'CRP-03',
                'status_pengajuan' => 'selesai',
                'waktu_pinjam' => now()->subDays(4)->setTime(10, 0),
                'waktu_kembali' => now()->subDays(4)->setTime(14, 10),
                'komentar_siswa' => 'Praktik crimping kabel LAN.',
                'balasan_admin' => 'Sudah dicek lengkap.',
            ],
            [
                'email' => 'amirakusumadjati@gmail.com',
                'kode_unit' => 'MLT-01',
                'status_pengajuan' => 'menunggu_konfirmasi',
                'waktu_pinjam' => now()->subDay()->setTime(7, 45),
                'waktu_kembali' => null,
                'komentar_siswa' => 'Multimeter masih normal, tinggal dicek admin.',
                'balasan_admin' => null,
            ],
        ];

        foreach ($loanBlueprints as $index => $blueprint) {
            $student = $students->get($blueprint['email']) ?? $fallbackStudents[$index] ?? null;
            $unit = $units->get($blueprint['kode_unit']);

            if (!$student || !$unit) {
                continue;
            }

            Peminjaman::create([
                'user_id' => $student->id,
                'unit_id' => $unit->id,
                'status_pengajuan' => $blueprint['status_pengajuan'],
                'waktu_pinjam' => Carbon::parse($blueprint['waktu_pinjam']),
                'waktu_kembali' => $blueprint['waktu_kembali'] ? Carbon::parse($blueprint['waktu_kembali']) : null,
                'komentar_siswa' => $blueprint['komentar_siswa'],
                'balasan_admin' => $blueprint['balasan_admin'],
            ]);

            $unit->update([
                'status' => in_array($blueprint['status_pengajuan'], ['aktif', 'menunggu_konfirmasi'], true)
                    ? 'Dipinjam'
                    : 'Tersedia',
            ]);
        }
    }

    /**
     * @param  \Illuminate\Support\Collection<string, \App\Models\Unit>  $units
     */
    protected function seedActivityLogs(Collection $units): void
    {
        $admin = User::where('role', 'admin')->first();

        if (!$admin) {
            return;
        }

        $logs = [
            [
                'aksi' => 'tambah_alat',
                'keterangan' => 'Menambahkan alat Laptop Lenovo ThinkPad beserta unit awal.',
                'model' => 'Alat',
                'model_id' => optional($units->get('LTP-01'))->alat_id,
                'data_lama' => null,
                'data_baru' => ['nama_alat' => 'Laptop Lenovo ThinkPad', 'jumlah_unit' => 3],
                'created_at' => now()->subDays(6),
            ],
            [
                'aksi' => 'import_siswa',
                'keterangan' => 'Import data siswa dari dump database awal.',
                'model' => 'User',
                'model_id' => $admin->id,
                'data_lama' => null,
                'data_baru' => ['sumber' => 'dbd_peminjaman_alat.sql'],
                'created_at' => now()->subDays(5),
            ],
            [
                'aksi' => 'konfirmasi_kembali',
                'keterangan' => 'Konfirmasi pengembalian Tang Crimping dari siswa.',
                'model' => 'Peminjaman',
                'model_id' => Peminjaman::where('status_pengajuan', 'selesai')->latest('id')->value('id'),
                'data_lama' => ['status_pengajuan' => 'menunggu_konfirmasi'],
                'data_baru' => ['status_pengajuan' => 'selesai'],
                'created_at' => now()->subDays(4),
            ],
        ];

        foreach ($logs as $log) {
            ActivityLog::create([
                'user_id' => $admin->id,
                'aksi' => $log['aksi'],
                'keterangan' => $log['keterangan'],
                'model' => $log['model'],
                'model_id' => $log['model_id'],
                'data_lama' => $log['data_lama'],
                'data_baru' => $log['data_baru'],
                'ip' => '127.0.0.1',
                'created_at' => $log['created_at'],
                'updated_at' => $log['created_at'],
            ]);
        }
    }
}
