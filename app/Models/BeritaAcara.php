<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeritaAcara extends Model
{
    use HasFactory;
    protected $table = 'berita_acara';

    protected $fillable = [
        'nip',
        'id_jadwal',
        'id_rps',
        'tanggal',
        'media',
        'jam_ajar',
        'minggu_ke',
        'status'
    ];
        public function matkul()
        {
            return $this->belongsTo(Matkul::class, 'id_matkul', 'id_matkul');  
        }
    
       
        public function dosen()
        {
            return $this->belongsTo(Dosen::class, 'nip', 'nip'); 
        }
    
       
        public function rps()
        {
            return $this->belongsTo(RPS::class, 'id_rps', 'id_rps'); 
        }
    
   
        public function jadwal()
        {
            return $this->belongsTo(Jadwal::class, 'id_jadwal', 'id_jadwal'); 
        }

        
    }

