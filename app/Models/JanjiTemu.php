<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JanjiTemu extends Model
{
    use HasFactory;
    protected $table        = 'janji_temu';
    protected $primaryKey   = 'nim';
    protected $fillable     = [
        'nim',
        'tanggal',
        'materi',
        'status'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }
}
