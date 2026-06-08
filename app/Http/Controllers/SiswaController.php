<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    // Daftar semua siswa + live search
    public function index(Request $request)
    {
        $query = User::where('role', 'siswa');

        if ($request->filled('cari')) {
            $q = $request->cari;
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%$q%")
                    ->orWhere('nis', 'like', "%$q%")
                    ->orWhere('email', 'like', "%$q%")
                    ->orWhere('kelas', 'like', "%$q%");
            });
        }

        // Filter by kelas
        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }

        $kelasList = User::where('role', 'siswa')
            ->pluck('kelas')
            ->filter()
            ->unique()
            ->sort()
            ->values();

        $siswas = $query->withCount([
            'peminjaman',
            'peminjaman as peminjaman_aktif' => fn($q) => $q->where('status_pengajuan', 'aktif'),
        ])->orderBy('name', 'asc')->paginate(30)->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'data' => $siswas->getCollection()->map(fn($s) => [
                    'id'               => $s->id,
                    'name'             => $s->name,
                    'nis'              => $s->nis,
                    'email'            => $s->email,
                    'kelas'            => $s->kelas ?? '-',
                    'peminjaman_count' => $s->peminjaman_count,
                    'peminjaman_aktif' => $s->peminjaman_aktif,
                    'fotoUrl'          => $s->fotoUrl(),
                ]),
                'total' => $siswas->total(),
            ]);
        }

        return view('admin.siswa.index', compact('siswas', 'kelasList'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls|max:5120',
        ], [
            'file.required' => 'File wajib diunggah.',
            'file.mimes'    => 'Format file harus .xlsx atau .xls',
            'file.max'      => 'Ukuran file maksimal 5MB.',
        ]);

        // Increase execution time for large imports
        set_time_limit(300);

        try {
            $file = $request->file('file');
            
            // Load Excel file
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->path());
            $sheet = $spreadsheet->getActiveSheet();
            
            $imported = 0;
            $skipped = 0;
            $errors = [];
            $usersToCreate = [];
            
            // Read header row to identify columns
            $headerRow = [];
            $headerIter = $sheet->getRowIterator(1, 1);
            foreach ($headerIter as $row) {
                $cellIter = $row->getCellIterator('A', 'Z');
                foreach ($cellIter as $cell) {
                    $val = trim((string)$cell->getValue());
                    if ($val === '') break;
                    $headerRow[] = strtolower($val);
                }
            }
            
            // Map header positions - flexible matching
            $colName = null;
            $colNis = null;
            $colKelas = null;
            $colStatus = null;
            
            foreach ($headerRow as $idx => $header) {
                if (in_array($header, ['nama', 'name', 'nama siswa', 'student name'])) {
                    $colName = $idx;
                } elseif (in_array($header, ['nis', 'nisn', 'no. induk siswa'])) {
                    $colNis = $idx;
                } elseif (in_array($header, ['kelas', 'class', 'tingkat'])) {
                    $colKelas = $idx;
                } elseif (in_array($header, ['status'])) {
                    $colStatus = $idx;
                }
            }
            
            // Validate required columns exist
            if ($colName === null || $colNis === null) {
                return redirect()->route('admin.siswa.index')
                    ->with('error', 'Format Excel tidak sesuai. Pastikan ada kolom: Nama, NIS, Kelas, Status');
            }
            
            // Start dari row 2 (row 1 adalah header)
            foreach ($sheet->getRowIterator(2) as $row) {
                $cellIterator = $row->getCellIterator();
                $data = [];
                foreach ($cellIterator as $cell) {
                    $data[] = (string)$cell->getValue();
                }
                
                // Extract data berdasarkan column positions
                $name = isset($data[$colName]) ? trim($data[$colName]) : '';
                $nis = isset($data[$colNis]) ? trim($data[$colNis]) : '';
                $kelas = isset($data[$colKelas]) ? trim($data[$colKelas]) : null;
                $status = isset($data[$colStatus]) ? trim($data[$colStatus]) : null;

                // Skip jika row kosong (minimal butir: name dan nis)
                if (!$name || !$nis) {
                    $skipped++;
                    continue;
                }

                // Cek duplikasi berdasarkan NIS saja
                if (\App\Models\User::where('nis', $nis)->exists()) {
                    $skipped++;
                    continue;
                }

                // Generate email dari nama: hapus spasi, lowercase, tambah @gmail.com
                $emailBase = strtolower(str_replace(' ', '', $name));
                $email = $emailBase . '@gmail.com';
                
                // Cek jika email sudah ada, tambah suffix NIS
                if (\App\Models\User::where('email', $email)->exists()) {
                    $email = $emailBase . $nis . '@gmail.com';
                    if (\App\Models\User::where('email', $email)->exists()) {
                        $skipped++;
                        continue;
                    }
                }
                
                // Add to batch array instead of creating immediately
                $usersToCreate[] = [
                    'name'       => $name,
                    'nis'        => $nis,
                    'email'      => $email,
                    'kelas'      => $kelas,
                    'password'   => bcrypt('siswa123'),
                    'role'       => 'siswa',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            
            // Batch insert all users at once to reduce database overhead
            if (!empty($usersToCreate)) {
                $chunks = array_chunk($usersToCreate, 50); // Insert 50 at a time
                foreach ($chunks as $chunk) {
                    try {
                        User::insert($chunk);
                        $imported += count($chunk);
                    } catch (\Exception $e) {
                        // If batch fails, try individually for debugging
                        foreach ($chunk as $userData) {
                            try {
                                User::create($userData);
                                $imported++;
                            } catch (\Exception $e) {
                                $skipped++;
                            }
                        }
                    }
                }
            }
            
            return redirect()->route('admin.siswa.index')
                ->with('success', "Import berhasil! $imported siswa ditambahkan. ($skipped data tidak valid atau duplikat)");
        } catch (\Exception $e) {
            return redirect()->route('admin.siswa.index')
                ->with('error', 'Error membaca file Excel: ' . $e->getMessage());
        }
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'nis'   => ['required', 'string', 'max:20', 'unique:users,nis,' . $user->id],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'kelas' => ['nullable', 'string'],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'nis.required'  => 'NIS wajib diisi.',
            'nis.unique'    => 'NIS sudah dipakai siswa lain.',
            'email.unique'  => 'Email sudah dipakai siswa lain.',
        ]);

        $user->update([
            'name'  => $request->name,
            'nis'   => $request->nis,
            'email' => $request->email,
            'kelas' => $request->kelas,
        ]);

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Data siswa ' . $user->name . ' berhasil diperbarui!');
    }

    public function destroy(User $user)
    {
        if ($user->isStaff()) {
            return redirect()->route('admin.siswa.index')
                ->with('error', 'Tidak bisa menghapus akun staf!');
        }

        if ($user->peminjaman()->where('status_pengajuan', 'aktif')->exists()) {
            return redirect()->route('admin.siswa.index')
                ->with('error', 'Tidak bisa menghapus siswa yang masih memiliki pinjaman aktif!');
        }

        $nama = $user->name;
        $user->delete();

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Akun siswa ' . $nama . ' berhasil dihapus.');
    }
}
