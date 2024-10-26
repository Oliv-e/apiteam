<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matkul extends Model
{
    use HasFactory;
    protected $table = 'matkul';

    protected $fillable = [
        'kode',
        'nama',
        'sks_teori',
        'sks_praktikum',
        'jam_teori',
        'jam_praktikum'
    ];
    public function rps(){
        return $this->hasMany(Rps::class, 'kode_matkul', 'kode');
    }
}
