<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Buat tabel activity_logs
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('aksi');
            $table->string('keterangan');
            $table->string('model')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->json('data_lama')->nullable();
            $table->json('data_baru')->nullable();
            $table->string('ip')->nullable();
            $table->timestamps();
        });

        // Tambah kolom ke users HANYA jika belum ada
        if (!Schema::hasColumn('users', 'foto_profil')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('foto_profil')->nullable()->after('kelas');
            });
        }
        if (!Schema::hasColumn('users', 'no_wa')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('no_wa')->nullable()->after('foto_profil');
            });
        }
    }

    public function down(): void {
        Schema::dropIfExists('activity_logs');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['foto_profil', 'no_wa']);
        });
    }
};
