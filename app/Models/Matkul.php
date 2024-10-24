<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matkul extends Model
{
    use HasFactory;
    protected $table = 'matkul';

    protected $fillable = [
        'kode_matkul',
        'nama_matkul',
        'jumlah_jam',
        'sks',
        
    ];
    public function rps(){
        return $this->hasMany(Rps::class, 'kode_matkul', 'kode_matkul');
        }
    public function matkul(){
        return $this->belongsTo(Matkul::class, 'nama_matkul', 'nama_matkul');
    }
    
}
