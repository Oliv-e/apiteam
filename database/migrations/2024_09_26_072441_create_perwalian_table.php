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
        Schema::create('konsultasi', function (Blueprint $table) {
            $table->id();
            $table->integer('nim');
            $table->dateTime('tanggal');
            $table->text('materi');
            $table->timestamps();
        });

        Schema::create('khs', function (Blueprint $table) {
            $table->id();
            $table->integer('semester');
            $table->string('tahun_ajaran');
            $table->string('status');
            $table->timestamps();
        });

        Schema::create('rekomendasi', function (Blueprint $table) {
            $table->id();
            $table->integer('nim');
            $table->string('jenis_rekomendasi');
            $table->dateTime('tanggal_pengajuan');
            $table->dateTime('tanggal_persetujuan');
            $table->text('keterangan');
            $table->string('status');
            $table->timestamps();
        });

        Schema::create('janji_temu', function (Blueprint $table) {
            $table->id();
            $table->integer('nim');
            $table->dateTime('tanggal');
            $table->text('materi');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perwalian');
    }
};