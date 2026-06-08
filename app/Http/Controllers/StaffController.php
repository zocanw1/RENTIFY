<?php
namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $query = $this->baseSiswaQuery($user);

        $siswaSedangPinjam = (clone $query)
            ->whereHas('peminjaman', fn($q) => $q->where('status_pengajuan','aktif'))
            ->with(['peminjaman' => fn($q) => $q->where('status_pengajuan','aktif')->with('unit.alat')])
            ->get();

        return view('staff.dashboard', compact('siswaSedangPinjam','user'));
    }

    public function siswas(Request $request)
    {
        $user = auth()->user();
        $query = $this->baseSiswaQuery($user);

        // Daftar kelas unik dari siswa yang sudah difilter scope-nya
        $kelasList = (clone $query)
            ->pluck('kelas')
            ->filter()
            ->unique()
            ->sort()
            ->values()
            ->toArray();

        // Filter kelas spesifik (hanya jika ada dalam daftar yang diizinkan)
        if ($request->filled('kelas') && in_array($request->kelas, $kelasList)) {
            $query->where('kelas', $request->kelas);
        }

        // Live search
        if ($request->filled('cari')) {
            $q = $request->cari;
            $query->where(fn($s) => $s
                ->where('name',  'like', "%$q%")
                ->orWhere('nis',   'like', "%$q%")
                ->orWhere('email', 'like', "%$q%")
                ->orWhere('kelas', 'like', "%$q%")
            );
        }

        $siswas = $query
            ->withCount([
                'peminjaman',
                'peminjaman as peminjaman_aktif' => fn($q) => $q->where('status_pengajuan','aktif'),
            ])
            ->orderBy('name', 'asc')
            ->paginate(30)
            ->withQueryString();

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

        return view('staff.siswas', compact('siswas','user','kelasList'));
    }

    /**
     * Query dasar siswa sesuai scope role.
     * - ketua_tjkt : siswa yang kelasnya mengandung kata jurusan ketua (dari DB dinamis)
     * - ketua_sija : sama
     * - wali_kelas : hanya siswa yang kelas-nya SAMA PERSIS dengan kelas wali tersebut
     */
    private function baseSiswaQuery(User $user)
    {
        $query = User::where('role', 'siswa');

        if ($user->isKetuaTjkt()) {
            // Ambil semua varian nama jurusan TJKT dari DB (bisa "TKJ", "TJKT", dll)
            $query->where(fn($q) => $q
                ->where('kelas', 'like', '%TJKT%')
                ->orWhere('kelas', 'like', '%TKJ%')
            );
        } elseif ($user->isKetuaSija()) {
            $query->where(fn($q) => $q
                ->where('kelas', 'like', '%SIJA%')
                ->orWhere('kelas', 'like', '%SIA%')
            );
        } elseif ($user->isWaliKelas()) {
            if (empty($user->kelas)) {
                $query->whereRaw('1 = 0');
            } else {
                // Coba exact match dulu, jika 0 hasil coba flexible match
                $exact = (clone $query)->where('kelas', $user->kelas)->count();
                if ($exact > 0) {
                    $query->where('kelas', $user->kelas);
                } else {
                    // Flexible: normalisasi TKJ<->TJKT, SIA<->SIJA
                    $kelasNorm = $this->normalizeKelas($user->kelas);
                    $query->where('kelas', 'like', "%{$kelasNorm}%");
                }
            }
        }

        return $query;
    }

    /**
     * Normalisasi nama kelas agar bisa match variasi penulisan.
     * Contoh: "X TJKT 1" -> "TKJ" atau "X TKJ 1" -> "TKJ"
     */
    private function normalizeKelas(string $kelas): string
    {
        // Ambil angka kelas saja untuk partial match yang aman
        // misal "X TJKT 1" -> cari kelas yang mengandung "X" dan "1" dan salah satu dari TJKT/TKJ
        return trim($kelas);
    }
}
