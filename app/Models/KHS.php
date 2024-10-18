<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KHS extends Model
{
    use HasFactory;
    protected $table    = 'khs';
    protected $fillable = [
        'nim',
        'semester',
        'tahun_ajaran',
        'status',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }
}
