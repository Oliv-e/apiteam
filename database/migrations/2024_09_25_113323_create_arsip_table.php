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

        Schema::create('dokumen', function (Blueprint $table) {
            $table->id();
            $table->integer('id_admin');
            $table->integer('id_kategori');
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('file_path');
            $table->integer('nomor_unik');
            $table->string('upload_by');
            $table->timestamps();
        });

        Schema::create('kategori', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kategori');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin');
    }
};
