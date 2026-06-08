<?php
namespace App\Http\Controllers;

use App\Http\Requests\AlatRequest;
use App\Models\ActivityLog;
use App\Models\Alat;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlatController extends Controller
{
    public function index() {
        $alats = Alat::withCount(['units','units as stok_tersedia'=>fn($q)=>$q->where('status','Tersedia'),'units as stok_dipinjam'=>fn($q)=>$q->where('status','Dipinjam'),'units as stok_rusak'=>fn($q)=>$q->where('status','Rusak'),'units as stok_diperbaiki'=>fn($q)=>$q->where('status','Diperbaiki')])->latest()->get();
        return view('admin.alat.index',compact('alats'));
    }

    public function show(Alat $alat) {
        $alat->load('units');
        $alat->loadCount(['units','units as stok_tersedia'=>fn($q)=>$q->where('status','Tersedia'),'units as stok_dipinjam'=>fn($q)=>$q->where('status','Dipinjam'),'units as stok_rusak'=>fn($q)=>$q->where('status','Rusak'),'units as stok_diperbaiki'=>fn($q)=>$q->where('status','Diperbaiki')]);
        return view('admin.alat.show',compact('alat'));
    }

    public function create() { return view('admin.alat.create'); }

    public function store(AlatRequest $request) {
        $path = $request->file('foto')->store('alat','public');
        $alat = Alat::create(['nama_alat'=>$request->nama_alat,'foto'=>$path]);
        $jumlah=(int)$request->jumlah_unit; $prefix=$request->prefix_unit;
        for ($i=1;$i<=$jumlah;$i++) {
            $fotoUnit=null;
            if ($request->hasFile("foto_unit.$i")) {
                $fotoUnit=$request->file("foto_unit.$i")->store('unit','public');
            } else {
                // Kalau tidak ada foto per unit, pakai foto alat utama (sama semua)
                $fotoUnit = $path;
            }
            Unit::create(['alat_id'=>$alat->id,'kode_unit'=>$prefix.'-'.$i,'status'=>'Tersedia','foto'=>$fotoUnit]);
        }
        ActivityLog::catat('tambah_alat','Menambahkan alat '.$alat->nama_alat.' dengan '.$jumlah.' unit','Alat',$alat->id);
        return redirect()->route('admin.alat.qr', $alat)->with('success',"Alat berhasil ditambahkan dengan {$jumlah} unit! QR langsung dibuat untuk setiap unit.");
    }

    public function edit(Alat $alat) { $alat->load('units'); return view('admin.alat.edit',compact('alat')); }

    public function update(AlatRequest $request, Alat $alat) {
        $data=['nama_alat'=>$request->nama_alat];
        if ($request->hasFile('foto')) { if ($alat->foto) Storage::disk('public')->delete($alat->foto); $data['foto']=$request->file('foto')->store('alat','public'); }
        $alat->update($data);
        if ($request->filled('tambah_unit')&&(int)$request->tambah_unit>0) {
            $sekarang=$alat->units()->count(); $tambah=(int)$request->tambah_unit; $prefix=$request->prefix_unit??strtolower(str_replace(' ','',$alat->nama_alat));
            for ($i=1;$i<=$tambah;$i++) Unit::create(['alat_id'=>$alat->id,'kode_unit'=>$prefix.'-'.($sekarang+$i),'status'=>'Tersedia']);
        }
        ActivityLog::catat('edit_alat','Mengedit alat '.$alat->nama_alat,'Alat',$alat->id);
        return redirect()->route('admin.alat.show',$alat)->with('success','Alat berhasil diperbarui!');
    }

    public function editUnit(Unit $unit) { $unit->load('alat'); return view('admin.alat.edit_unit',compact('unit')); }

    public function updateUnit(Request $request, Unit $unit) {
        $request->validate(['kode_unit'=>['required','string','max:100'],'foto'=>['nullable','image','max:2048']]);
        $data=['kode_unit'=>$request->kode_unit];
        if ($request->hasFile('foto')) { if ($unit->foto) Storage::disk('public')->delete($unit->foto); $data['foto']=$request->file('foto')->store('unit','public'); }
        if ($request->has('hapus_foto')&&$unit->foto) { Storage::disk('public')->delete($unit->foto); $data['foto']=null; }
        $unit->update($data);
        ActivityLog::catat('edit_unit','Mengedit unit '.$unit->kode_unit.' pada '.$unit->alat->nama_alat,'Unit',$unit->id);
        return redirect()->route('admin.alat.show',$unit->alat_id)->with('success','Unit berhasil diperbarui!');
    }

    public function updateStatusUnit(Request $request, Unit $unit) {
        $request->validate(['status'=>['required','in:Tersedia,Rusak,Diperbaiki']]);
        if ($unit->status==='Dipinjam') return response()->json(['error'=>'Unit sedang dipinjam.'],422);
        $lama=$unit->status; $unit->update(['status'=>$request->status]);
        ActivityLog::catat('update_status_unit','Mengubah status unit '.$unit->kode_unit.' dari '.$lama.' → '.$request->status,'Unit',$unit->id);
        return response()->json(['success'=>true,'status'=>$unit->status]);
    }

    public function destroyUnit(Unit $unit) {
        $alatId=$unit->alat_id;
        if ($unit->status==='Dipinjam') return back()->with('error','Tidak bisa hapus unit yang sedang dipinjam!');
        if ($unit->foto) Storage::disk('public')->delete($unit->foto);
        ActivityLog::catat('hapus_unit','Menghapus unit '.$unit->kode_unit.' dari '.$unit->alat->nama_alat,'Unit',$unit->id);
        $unit->delete();
        return redirect()->route('admin.alat.show',$alatId)->with('success','Unit berhasil dihapus!');
    }

    public function destroy(Alat $alat) {
        ActivityLog::catat('hapus_alat','Menghapus alat '.$alat->nama_alat.' beserta semua unitnya','Alat',$alat->id);
        if ($alat->foto) Storage::disk('public')->delete($alat->foto);
        
        // Hapus semua units terlebih dahulu
        foreach ($alat->units as $u) {
            if ($u->foto) Storage::disk('public')->delete($u->foto);
            // Hapus peminjaman yang terkait dengan unit ini
            $u->peminjaman()->delete();
            // Baru hapus unit
            $u->delete();
        }
        
        // Setelah semua units terhapus, baru hapus alat
        $alat->delete();
        return redirect()->route('admin.alat.index')->with('success','Alat berhasil dihapus!');
    }
}
