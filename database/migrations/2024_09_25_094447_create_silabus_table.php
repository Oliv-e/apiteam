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
            $table->id('id_infomatkul');  // Primary key
            $table->string('nama_matkul');
            $table->string('kode_matkul');
            $table->integer('semester');
            $table->string('dosen');
            $table->integer('sks'); 
            $table->text('deskripsi'); 
            $table->text('cp_prodi'); 
            $table->text('cp_matkul'); 
            $table->text('bobot_penilaian'); 
            $table->text('metode_penilaian'); 
            $table->text('buku_referensi');
            $table->timestamps(); // Membuat kolom created_at dan updated_at
        });

        // Membuat tabel jadwal_pelaksanaan
        Schema::create('jadwal_pelaksanaan', function (Blueprint $table) {
            $table->id('i   d_jadwal');//jadikan primary dan auto inc
            $table->integer('minggu_ke'); 
            $table->time('waktu');
            $table->text('cp_tahapan_matkul');
            $table->text('bahan_kajian'); 
            $table->text('sub_bahan_kajian'); 
            $table->text('bentuk_pembelajaran'); 
            $table->text('kriteria_penilaian'); 
            $table->text('pengalaman_belajar'); 
            $table->text('bobot_materi'); 
            $table->string(column: 'referensi'); 
            $table->timestamps(); // Menambahkan kolom created_at dan updated_at
        });
    }

    //     // Membuat tabel rps
    //     Schema::create('rps', function (Blueprint $table) {
    //         $table->id('id_rps');
    //         $table->unsignedBigInteger('nip');
    //         $table->unsignedBigInteger('kode_matkul');
    //         $table->unsignedBigInteger('id_referensi');
    //         $table->text('deskripsi');
    //         $table->text('cp_prodi');
    //         $table->text('cp_matkul');
    //         $table->text('bobot_penilaian');
    //         $table->text('metode_penilaian');
    //         $table->integer('minggu_ke');
    //         $table->time('waktu');
    //         $table->text('cp_tahapan_matkul');
    //         $table->text('bahan_kajian');
    //         $table->text('sub_bahan_kajian');
    //         $table->text('bentuk_pembelajaran');
    //         $table->text('bahan_pembelajaran');
    //         $table->text('kriteria_penilaian');
    //         $table->text('bobot_materi');
    //         $table->date('tanggal_pembuatan');
    //         $table->date('tanggal_referensi')->nullable(); // Typo diperbaiki dari 'tanggal_refrensi' ke 'tanggal_referensi'
    //         $table->enum('status_persetujuan',['Disteujui','Proses'])->default('Proses');
    //         $table->date('tanggal_persetujuan');
    //         $table->timestamps(); // Membuat kolom created_at dan updated_at
    //     });
    // }

    /**
     * Reverse the migrations. 
     */
    public function down(): void
    {
        Schema::dropIfExists('silabus');
    }
};
