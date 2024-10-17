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
        Schema::create('referensi', function (Blueprint $table) {
            $table->id('id_referensi');
            $table->string('buku_referensi');
            $table->timestamps();
        });

        // Membuat tabel rps
        schema::create('rps', function (Blueprint $table){
            $table->id('id_rps');
            $table->unsignedBiginteger('nip');
            $table->unsignedBiginteger('kode_matkul');
            $table->unsignedBiginteger('id_referensi');
            $table->text('deskripsi');
            $table->string('cp_prodi');
            $table->string('cp_matkul');
            $table->string('bobot_penilaian');
            $table->string('metode_penilaian');
            $table->integer('minggu_ke');
            $table->time('waktu');
            $table->string('cp_tahapan_matkul');
            $table->string('bahan_kajian');
            $table->string('sub_bahan_kajian');
            $table->string('bentuk_pembelajaran');
            $table->string('kriterian_penilaian');
            $table->string('bobot_materi');
            $table->date('tanggal_pembuatan');
            $table->date('tanggal_refrensi')->nullable();
            $table->boolean('status_persetujuan');
            $table->date('tanggal_persetujuan');
            //tambah tabel untuk ttd qr code
            $table->timestamps();


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
