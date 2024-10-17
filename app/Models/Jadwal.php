<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;
    protected $table = 'jadwal';

    protected $fillable = [
        'id_jadwal',
        'id_kelas',
        'kode_matkul',
        'id_ruang',
        'hari',
        'start',
        'finish',
        'semester',    
    ];
    public function matkul(){
        return $this->belongsto(matkul::class, 'kode_matkul', 'kode_matkul');
    }
    public function kelas(){
        return $this->belongsto(kelas::class, 'id_kelas', 'id_kelas');
    }
    public function ruang(){
        return $this->belongsto(ruang::class, 'id_ruang', 'id_ruang');
    }
}

