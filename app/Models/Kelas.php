<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    protected $table = 'kelas';
    protected $fillable = [
        'id_kelas',
        'abjad_kelas'
    ];
    public function matkul()
{
    return $this->belongsTo(Matkul::class, 'matkul_id', 'id'); 
}

public function dosen()
{
    return $this->belongsTo(Dosen::class, 'dosen_id', 'id'); 
}
}
