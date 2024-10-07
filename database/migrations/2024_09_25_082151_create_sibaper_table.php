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
        Schema::create('berita_acara', function (Blueprint $table) {
            $table->id('id_jadwal');
            $table->integer('id_rps');
            $table->dateTime('tanggal');
            $table->string('media');
            $table->time('jam_ajar');
            $table->timestamps();
        });

        Schema::create('jadwal', function (Blueprint $table) {
            $table->id('id_jadwal');
            $table->integer('nip');
            $table->integer('id_kelas');
            $table->integer('id_ruang');
            $table->string('kode_matkul');
            $table->string('hari');
            $table->integer('semester');
            $table->time('start');
            $table->time('finish');
            $table->timestamps();
        });

        Schema::create('ruang', function (Blueprint $table) {
            $table->id('id_ruang');
            $table->string('nama_ruang');
            $table->timestamps();
        });

        Schema::create('kelas', function (Blueprint $table) {
            $table->id('id_kelas');
            $table->string('abjad_kelas');
            $table->timestamps();
        });

        Schema::create('matkul', function (Blueprint $table) {
            $table->string('kode_matkul')->primary();
            $table->integer('jumlah_jam');
            $table->integer('jumlah_SKS');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sibaper');
    }
};
