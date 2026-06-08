<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(SqlSnapshotSeeder::class);

        // Settings default
        \App\Models\Setting::firstOrCreate(['key'=>'batas_jam_kembali'],['value'=>'15:00','keterangan'=>'Batas waktu pengembalian alat (HH:MM)']);
        \App\Models\Setting::firstOrCreate(['key'=>'nama_sekolah'],['value'=>'SMK','keterangan'=>'Nama sekolah untuk laporan']);

        // ─── Admin ───────────────────────────────────────────────
        User::firstOrCreate(['email' => 'admin@wepinjam.id'], [
            'name'     => 'Admin WePinjam',
            'nis'      => '0000000001',
            'kelas'    => null,
            'role'     => 'admin',
            'password' => Hash::make('admin123'),
        ]);

        // ─── Ketua Jurusan TJKT ───────────────────────────────────
        User::firstOrCreate(['email' => 'ketua.tjkt@wepinjam.id'], [
            'name'     => 'Ketua Jurusan TJKT',
            'nis'      => '0000000002',
            'kelas'    => null,
            'role'     => 'ketua_tjkt',
            'password' => Hash::make('ketua123'),
        ]);

        // ─── Ketua Jurusan SIJA ───────────────────────────────────
        User::firstOrCreate(['email' => 'ketua.sija@wepinjam.id'], [
            'name'     => 'Ketua Jurusan SIJA',
            'nis'      => '0000000003',
            'kelas'    => null,
            'role'     => 'ketua_sija',
            'password' => Hash::make('ketua123'),
        ]);

        // ─── Wali Kelas ──────────────────────────────────────────
        // PENTING: format kelas harus sama persis dengan data siswa di DB
        // Sesuaikan list ini dengan format kelas yang dipakai saat import siswa
        $kelasList = [
            'X TKJ 1','X TKJ 2','X SIJA 1','X SIJA 2',
            'XI TKJ 1','XI TKJ 2','XI SIJA 1','XI SIJA 2',
            'XII TKJ 1','XII TKJ 2','XII SIJA 1','XII SIJA 2',
        ];

        foreach ($kelasList as $i => $kelas) {
            $slug  = strtolower(str_replace([' ', '/'], ['.', ''], $kelas));
            $email = "wali.{$slug}@wepinjam.id";
            $nis = '000000' . str_pad($i + 10, 4, '0', STR_PAD_LEFT);

            User::firstOrCreate(['nis' => $nis], [
                'name' => "Wali Kelas {$kelas}",
                'email' => $email,
                'kelas' => $kelas,
                'role' => 'wali_kelas',
                'password' => Hash::make('wali123'),
            ]);
        }

        if (User::where('role', 'siswa')->doesntExist()) {
            $this->call(SiswaSeeder::class);
        }

        $this->call(InventorySeeder::class);
    }
}
