<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarkedDokumen extends Model
{
    protected $table = 'marked_dokumen';
    protected $fillable = [
        'nip',
        'id_dokumen'
    ];

    public function dosen() {
        return $this->belongsTo(Dosen::class, 'nip', 'nip');
    }
    public function dokumen() {
        return $this->belongsTo(Dokumen::class, 'id_dokumen', 'id');
    }
}
