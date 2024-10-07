<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->id('nim');
            $table->string('nama');
            $table->string('kode_prodi');
            $table->integer('semester');
            $table->integer('id_kelas');
            $table->integer('nip');
            $table->string('no_hp');
            $table->timestamps();
        });

        Schema::create('jurusan', function (Blueprint $table) {
            $table->string('kode_jurusan')->primary();
            $table->string('nama_jurusan');
            $table->timestamps();
        });

        Schema::create('prodi', function (Blueprint $table) {
            $table->string('kode_prodi')->primary();
            $table->string('kode_jurusan');
            $table->string('nama_prodi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswa');
    }
};
