<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alat_id')->constrained();
            $table->string('kode_unit');
            $table->string('foto')->nullable();                                                      // Foto per unit
            $table->enum('status', ['Tersedia','Dipinjam','Rusak','Diperbaiki'])->default('Tersedia'); // +Diperbaiki
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
