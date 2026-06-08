<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjamen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('unit_id')->constrained();
            $table->enum('status_pengajuan', ['aktif','menunggu_konfirmasi','selesai'])->default('aktif');
            $table->dateTime('waktu_pinjam');
            $table->dateTime('waktu_kembali')->nullable();
            $table->text('komentar_siswa')->nullable();    // Komentar siswa saat kembalikan
            $table->text('balasan_admin')->nullable();     // Balasan admin
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjamen');
    }
};
