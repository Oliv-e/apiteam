<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Infomatkul extends Model
{

    use HasFactory;

    // Nama tabel di database
    protected $table = 'infomatkul';
    protected $primary  = 'id';

    protected $fillable = [
        'kode_matkul',
        'semester',
        'nip',
        'sks',
        'deskripsi',
        'cp_prodi',
        'cp_matkul',
        'bobot_penilaian',
        'metode_penilaian',
        'buku_referensi'
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
    
    public function jabatan()
    {
        return $this->hasOne(Jabatan::class, 'nip',   'nip');
    }
}

