<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        $kelasList = [
            'X TJKT 1','X TJKT 2','X SIJA 1','X SIJA 2',
            'XI TJKT 1','XI TJKT 2','XI SIJA 1','XI SIJA 2',
            'XII TJKT 1','XII TJKT 2','XII SIJA 1','XII SIJA 2',
        ];

        $counter = 1000;
        foreach ($kelasList as $kelas) {
            for ($i = 1; $i <= 3; $i++) {
                $name = "Siswa {$kelas} {$i}";
                $email = strtolower(str_replace([' ', '/'], ['.', ''], $name)) . "@example.test";
                User::firstOrCreate([
                    'email' => $email,
                ], [
                    'name' => $name,
                    'nis'  => (string) ($counter++),
                    'kelas'=> $kelas,
                    'role' => 'siswa',
                    'password' => Hash::make('password'),
                ]);
            }
        }
    }
}
