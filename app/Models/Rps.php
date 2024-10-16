<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rps extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'rps';

    protected $fillable = [
        'nip',
        'kode_matkul',
        'id_referensi',
        'deskripsi',
        'cp_prodi',
        'cp_matkul',
        'bobot_penilaian',
        'metode_penilaian',
        'minggu_ke',
        'waktu',
        'cp_tahapan_matkul',
        'bahan_kajian',
        'sub_bahan_kajian',
        'bentuk_pembelajaran',
        'kriteria_penilaian',
        'bobot_materi',
        'tanggal_pembuatan',
        'tanggal_referensi',
        'status_persetujuan',
        'tanggal_persetujuan'
    ];

    public function referensi()
    {
        return $this->belongsTo(Referensi::class, 'id_referensi');
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'nip', 'nip');
    }

    public function matkul()
    {
        return $this->belongsTo(Matkul::class, 'kode_matkul',   'kode_matkul');
    }
}
