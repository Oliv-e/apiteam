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
        'nama',
        'sks',
        'semester',
    ];
    public function infomatkul(){
        return $this->belongTo(Infomatkul::class, 'kode_matkul', 'kode_matkul');
    }
}
