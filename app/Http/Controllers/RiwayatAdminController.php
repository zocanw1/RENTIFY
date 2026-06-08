<?php
namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class RiwayatAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with(['user','unit.alat'])->latest();
        if ($request->filled('cari')) {
            $q = $request->cari;
            $query->whereHas('user',fn($u)=>$u->where('name','like',"%$q%")->orWhere('nis','like',"%$q%"));
        }
        if ($request->filled('status'))  $query->where('status_pengajuan',$request->status);
        if ($request->filled('kelas'))   $query->whereHas('user',fn($u)=>$u->where('kelas',$request->kelas));
        if ($request->filled('bulan')) { [$y,$m]=explode('-',$request->bulan); $query->whereYear('waktu_pinjam',$y)->whereMonth('waktu_pinjam',$m); }

        $riwayats  = $query->paginate(20)->withQueryString();
        $kelasList = ['X TJKT 1','X TJKT 2','X SIJA 1','X SIJA 2','XI TJKT 1','XI TJKT 2','XI SIJA 1','XI SIJA 2','XII TJKT 1','XII TJKT 2','XII SIJA 1','XII SIJA 2'];

        return view('admin.riwayat.index',compact('riwayats','kelasList'));
    }

    public function siswa(User $user)
    {
        $riwayats = Peminjaman::where('user_id',$user->id)->with('unit.alat')->latest()->get();
        $stats = [
            'total'     => $riwayats->count(),
            'selesai'   => $riwayats->where('status_pengajuan','selesai')->count(),
            'aktif'     => $riwayats->where('status_pengajuan','aktif')->count(),
            'terlambat' => $riwayats->filter(fn($p)=>$p->isTerlambat()&&$p->status_pengajuan!=='selesai')->count(),
        ];
        return view('admin.riwayat.siswa',compact('user','riwayats','stats'));
    }

    // PDF riwayat 1 siswa
    public function siswaPdf(User $user)
    {
        $riwayats = Peminjaman::where('user_id',$user->id)->with('unit.alat')->latest()->get();
        $stats = [
            'total'     => $riwayats->count(),
            'selesai'   => $riwayats->where('status_pengajuan','selesai')->count(),
            'aktif'     => $riwayats->where('status_pengajuan','aktif')->count(),
            'terlambat' => $riwayats->filter(fn($p)=>$p->isTerlambat()&&$p->status_pengajuan!=='selesai')->count(),
        ];
        return view('admin.riwayat.siswa-pdf',compact('user','riwayats','stats'));
    }

    // Excel riwayat 1 siswa
    public function siswaExcel(User $user)
    {
        $riwayats = Peminjaman::where('user_id',$user->id)->with('unit.alat')->latest()->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Riwayat '.$user->name);

        // Judul
        $sheet->mergeCells('A1:F1');
        $sheet->setCellValue('A1','RIWAYAT PEMINJAMAN — '.$user->name);
        $sheet->getStyle('A1')->applyFromArray(['font'=>['bold'=>true,'size'=>13,'color'=>['rgb'=>'FFFFFF']],'fill'=>['fillType'=>Fill::FILL_SOLID,'startColor'=>['rgb'=>'4F46E5']],'alignment'=>['horizontal'=>Alignment::HORIZONTAL_CENTER]]);
        $sheet->getRowDimension(1)->setRowHeight(28);

        $sheet->mergeCells('A2:F2');
        $sheet->setCellValue('A2','NIS: '.$user->nis.' | Kelas: '.($user->kelas??'-').' | Dicetak: '.now()->format('d/m/Y H:i'));
        $sheet->getStyle('A2')->applyFromArray(['font'=>['size'=>9,'color'=>['rgb'=>'6B7280']],'alignment'=>['horizontal'=>Alignment::HORIZONTAL_CENTER]]);

        $headers = ['No','Nama Alat','Kode Unit','Waktu Pinjam','Waktu Kembali','Status'];
        $cols = ['A','B','C','D','E','F'];
        foreach ($headers as $i => $h) {
            $cell = $cols[$i].'4';
            $sheet->setCellValue($cell,$h);
            $sheet->getStyle($cell)->applyFromArray(['font'=>['bold'=>true,'color'=>['rgb'=>'FFFFFF']],'fill'=>['fillType'=>Fill::FILL_SOLID,'startColor'=>['rgb'=>'4338CA']],'alignment'=>['horizontal'=>Alignment::HORIZONTAL_CENTER],'borders'=>['allBorders'=>['borderStyle'=>Border::BORDER_THIN,'color'=>['rgb'=>'6366F1']]]]);
        }

        foreach ($riwayats as $i => $p) {
            $row = $i+5;
            $bg  = $i%2===0?'FFFFFF':'EEF2FF';
            $terlambat = $p->isTerlambat() && $p->status_pengajuan!=='selesai';
            $statusTeks = match(true) {
                $p->status_pengajuan==='selesai' => 'Selesai',
                $terlambat => '⚠️ Terlambat '.$p->durasiTerlambat(),
                $p->status_pengajuan==='menunggu_konfirmasi' => 'Menunggu',
                default => 'Aktif',
            };
            $rowData = [$i+1,$p->unit->alat->nama_alat,$p->unit->kode_unit,$p->waktu_pinjam->format('d/m/Y H:i'),$p->waktu_kembali?->format('d/m/Y H:i')??'—',$statusTeks];
            foreach ($rowData as $j => $val) {
                $cell = $cols[$j].$row;
                $sheet->setCellValue($cell,$val);
                $statusColor = $terlambat?'DC2626':match($p->status_pengajuan){'selesai'=>'059669','menunggu_konfirmasi'=>'D97706',default=>'CA8A04'};
                $sheet->getStyle($cell)->applyFromArray(['fill'=>['fillType'=>Fill::FILL_SOLID,'startColor'=>['rgb'=>$terlambat&&$j===5?'FEE2E2':$bg]],'borders'=>['allBorders'=>['borderStyle'=>Border::BORDER_THIN,'color'=>['rgb'=>'E5E7EB']]],'font'=>$j===5?['bold'=>true,'color'=>['rgb'=>$statusColor]]:[]]);
            }
        }

        foreach ($cols as $col) $sheet->getColumnDimension($col)->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        $filename = 'riwayat-'.str_replace(' ','-',$user->name).'.xlsx';
        return response()->streamDownload(fn()=>$writer->save('php://output'),$filename,['Content-Type'=>'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']);
    }

    // Export Excel semua
    public function exportExcel(Request $request)
    {
        $query = Peminjaman::with(['user','unit.alat'])->latest();
        $filter=$request->filter??'bulan'; $bulan=$request->bulan??now()->format('Y-m'); $tahun=$request->tahun??now()->year;
        if ($filter==='bulan') { [$y,$m]=explode('-',$bulan); $query->whereYear('waktu_pinjam',$y)->whereMonth('waktu_pinjam',$m); $judulPeriode=\Carbon\Carbon::parse($bulan)->translatedFormat('F Y'); }
        elseif ($filter==='tahun') { $query->whereYear('waktu_pinjam',$tahun); $judulPeriode='Tahun '.$tahun; }
        else { $judulPeriode='Semua Data'; }
        $data=$query->get();

        $spreadsheet=new Spreadsheet();
        $sheet=$spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan Peminjaman');
        $sheet->mergeCells('A1:I1');
        $sheet->setCellValue('A1','LAPORAN PEMINJAMAN ALAT - WEPINJAM');
        $sheet->getStyle('A1')->applyFromArray(['font'=>['bold'=>true,'size'=>14,'color'=>['rgb'=>'FFFFFF']],'fill'=>['fillType'=>Fill::FILL_SOLID,'startColor'=>['rgb'=>'4F46E5']],'alignment'=>['horizontal'=>Alignment::HORIZONTAL_CENTER]]);
        $sheet->getRowDimension(1)->setRowHeight(30);
        $sheet->mergeCells('A2:I2');
        $sheet->setCellValue('A2','Periode: '.$judulPeriode.' | Dicetak: '.now()->format('d/m/Y H:i'));
        $sheet->getStyle('A2')->applyFromArray(['font'=>['size'=>10,'color'=>['rgb'=>'6B7280']],'alignment'=>['horizontal'=>Alignment::HORIZONTAL_CENTER]]);

        $headers=['No','Nama Siswa','NIS','Kelas','Nama Alat','Kode Unit','Waktu Pinjam','Waktu Kembali','Status'];
        $cols=['A','B','C','D','E','F','G','H','I'];
        foreach ($headers as $i=>$h) {
            $cell=$cols[$i].'4'; $sheet->setCellValue($cell,$h);
            $sheet->getStyle($cell)->applyFromArray(['font'=>['bold'=>true,'color'=>['rgb'=>'FFFFFF']],'fill'=>['fillType'=>Fill::FILL_SOLID,'startColor'=>['rgb'=>'4338CA']],'alignment'=>['horizontal'=>Alignment::HORIZONTAL_CENTER],'borders'=>['allBorders'=>['borderStyle'=>Border::BORDER_THIN,'color'=>['rgb'=>'6366F1']]]]);
        }
        $sheet->getRowDimension(4)->setRowHeight(22);
        foreach ($data as $i=>$p) {
            $row=$i+5; $bg=$i%2===0?'FFFFFF':'EEF2FF';
            $terlambat=$p->isTerlambat()&&$p->status_pengajuan!=='selesai';
            $rowData=[$i+1,$p->user->name,$p->user->nis,$p->user->kelas??'-',$p->unit->alat->nama_alat,$p->unit->kode_unit,$p->waktu_pinjam->format('d/m/Y H:i'),$p->waktu_kembali?->format('d/m/Y H:i')??'-',
                $terlambat?'⚠️ Terlambat':match($p->status_pengajuan){'selesai'=>'Selesai','menunggu_konfirmasi'=>'Menunggu',default=>'Aktif'}];
            foreach ($rowData as $j=>$val) {
                $cell=$cols[$j].$row; $sheet->setCellValue($cell,$val);
                $sc=$terlambat?'DC2626':match($p->status_pengajuan){'selesai'=>'059669','menunggu_konfirmasi'=>'D97706',default=>'CA8A04'};
                $sheet->getStyle($cell)->applyFromArray(['fill'=>['fillType'=>Fill::FILL_SOLID,'startColor'=>['rgb'=>$terlambat&&$j===8?'FEE2E2':$bg]],'borders'=>['allBorders'=>['borderStyle'=>Border::BORDER_THIN,'color'=>['rgb'=>'E5E7EB']]],'font'=>$j===8?['bold'=>true,'color'=>['rgb'=>$sc]]:[]]);
            }
        }
        foreach ($cols as $col) $sheet->getColumnDimension($col)->setAutoSize(true);
        $lastRow=count($data)+6; $sheet->setCellValue('A'.$lastRow,'Total: '.count($data).' transaksi');
        $sheet->getStyle('A'.$lastRow)->getFont()->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('4F46E5'));

        $writer=new Xlsx($spreadsheet);
        $filename='laporan-peminjaman-'.str_replace(' ','-',$judulPeriode).'.xlsx';
        return response()->streamDownload(fn()=>$writer->save('php://output'),$filename,['Content-Type'=>'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']);
    }

    public function hapus($id)
    {
        $pinjaman = \App\Models\Peminjaman::findOrFail($id);

        // Hanya boleh hapus yang sudah selesai
        if ($pinjaman->status_pengajuan !== 'selesai') {
            return back()->with('error', 'Hanya riwayat yang sudah selesai yang bisa dihapus!');
        }

        \App\Models\ActivityLog::catat(
            'hapus_riwayat',
            'Menghapus riwayat pinjam ' . $pinjaman->unit->alat->nama_alat . ' oleh ' . $pinjaman->user->name,
            'Peminjaman', $pinjaman->id
        );

        $pinjaman->delete();

        return back()->with('success', 'Riwayat peminjaman berhasil dihapus!');
    }
}
