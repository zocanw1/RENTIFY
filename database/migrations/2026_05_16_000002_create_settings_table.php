<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('value');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });

        DB::table('settings')->insert([
            ['key'=>'batas_jam_kembali', 'value'=>'15:00', 'keterangan'=>'Batas waktu pengembalian alat hari ini (HH:MM)', 'created_at'=>now(),'updated_at'=>now()],
            ['key'=>'nama_sekolah',      'value'=>'SMK',   'keterangan'=>'Nama sekolah untuk laporan',                    'created_at'=>now(),'updated_at'=>now()],
        ]);
    }
    public function down(): void { Schema::dropIfExists('settings'); }
};
