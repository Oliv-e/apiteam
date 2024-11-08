<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;

    protected $table = 'jabatan';

    protected $fillable = [
        'nip',
        'is_prodi',
        'is_kajur',
    ];
    
    public function infomatkul()
    {
        return $this->hasOne(Infomatkul::class, 'nip',   'nip');
    }
}
