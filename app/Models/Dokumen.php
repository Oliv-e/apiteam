<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    use HasFactory;
    protected $table = 'dokumen';
    protected $fillable = [
        'title',
        'deskripsi',
        'no_surat',
        'tanggal_surat',
        'kategori',
        'jenis',
        'tahun_akademik',
        'filepath'
    ];
    public $timestamps = false;
}
