<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPelaksanaan extends Model
{

    use HasFactory;


    // Nama tabel di database
    protected $table = 'jadwal_pelaksanaan';

    protected $fillable = [
        'minggu_ke',
        'waktu',
        'cp_tahapan_matkul',
        'bahan_kajian',
        'sub_bahan_kajian',
        'bentuk_pembelajaran',
        'kriteria_penilaian',
        'pengalaman_belajar',
        'bobot_materi',
        'referensi'
    ];

    // public function referensi()
    // {
    //     return $this->belongsTo(Referensi::class, 'id_referensi', 'id_referensi');
    // }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'nip', 'nip');
    }

    // public function matkul()
    // {
    //     return $this->belongsTo(Matkul::class, 'kode_matkul',   'kode_matkul');
    // }
}

