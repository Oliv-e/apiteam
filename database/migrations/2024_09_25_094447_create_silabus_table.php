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
        // Membuat tabel referensi
        Schema::create('referensi', function (Blueprint $table) {
            $table->id('id_referensi');
            $table->string('buku_referensi')->nullable();
            $table->timestamps(); // Membuat kolom created_at dan updated_at
        });

        Schema::create('infomatkul', function(Blueprint $table) {
            $table->id('id');  // Primary key
            $table->string('kode_matkul');
            $table->integer('semester');
            $table->bigint('nip');
            $table->integer('sks');
            $table->text('deskripsi');
            $table->text('cp_prodi');
            $table->text('cp_matkul');
            $table->text('bobot_penilaian');
            $table->text('metode_penilaian');
            $table->text('buku_referensi');
            $table->enum('status', ['disetujui', 'tidak disetujui', 'proses'])->default('proses'));
            $table->timestamps(); // Membuat kolom created_at dan updated_at
        });

        // Membuat tabel jadwal_pelaksanaan
        Schema::create('jadwal_pelaksanaan', function (Blueprint $table) {
            $table->id('id');//jadikan primary dan auto inc
            $table->integer('minggu_ke');
            $table->text('waktu');
            $table->text('cp_tahapan_matkul');
            $table->text('bahan_kajian');
            $table->text('sub_bahan_kajian');
            $table->text('bentuk_pembelajaran');
            $table->text('kriteria_penilaian');
            $table->text('pengalaman_belajar');
            $table->text('bobot_materi');
            $table->string('referensi');
            $table->timestamps(); // Menambahkan kolom created_at dan updated_at
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('silabus');
    }
};
