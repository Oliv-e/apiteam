<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;
    protected $table = 'mahasiswa';

    protected $fillable = [
        'nim',
        'nama',
        'kode_prodi',
        'semester',
        'id_kelas',
        'nip',
        'no_hp',
    ];

    public function janji_temu() {
        return $this->hasMany(JanjiTemu::class, 'nim', 'nim');
    }
    public function rekomendasi() {
        return $this->hasMany(Rekomendasi::class, 'nim', 'nim');
    }
    public function prodi() {
        return $this->belongsTo(Prodi::class, 'kode_prodi', 'kode_prodi');
    }
    public function kelas() {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }
    public function dosen_pembimbing() {
        return $this->belongsTo(Dosen::class, 'nip', 'nip');
    }
}
