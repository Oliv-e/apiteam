<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    use HasFactory;
    protected $table = 'dokumen';
    protected $fillable = [
        'id_admin',
        'id_kategori',
        'nama_kategori',
        'judul',
        'deskripsi',
        'file_path',
        'nomor_unik',
        'upload_by'
    ];
    public function admin() {
        return $this->belongsTo(StaffAdmin::class, 'id_admin', 'id_admin');
    }
}
