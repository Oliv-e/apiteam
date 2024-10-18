<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruang extends Model
{
    use HasFactory;
    protected $table = 'ruang';

    protected $fillable = [
        'id_ruang',
        'nama_ruang',
    ];

    public function jadwal()
{
    return $this->hasMany(Jadwal::class, 'id_ruang', 'id_ruang');
}
}

