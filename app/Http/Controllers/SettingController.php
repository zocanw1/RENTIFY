<?php
namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->keyBy('key');
        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'batas_jam_kembali' => ['required', 'regex:/^\d{2}:\d{2}$/'],
            'nama_sekolah'      => ['required', 'string', 'max:100'],
        ], [
            'batas_jam_kembali.required' => 'Batas jam wajib diisi.',
            'batas_jam_kembali.regex'    => 'Format jam harus HH:MM, contoh: 15:00',
        ]);

        Setting::set('batas_jam_kembali', $request->batas_jam_kembali);
        Setting::set('nama_sekolah',      $request->nama_sekolah);

        ActivityLog::catat('edit_setting',
            'Mengubah setting: batas jam kembali → ' . $request->batas_jam_kembali);

        return back()->with('success', 'Pengaturan berhasil disimpan!');
    }
}
