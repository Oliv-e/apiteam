<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $table = 'dosen';
    protected $fillable = [
        'nip',
        'nama',
        'no_hp'
    ];

    //relasi ke rps
    public function rps()
    {
        return $this->hasMany(Rps::class, 'nip', 'nip');
    }
}
