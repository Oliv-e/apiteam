<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

class Rekomendasi extends Model
{
    use HasFactory;
    protected $table        = 'rekomendasi';
    protected $fillable     = [
        'nim',
        'jenis_rekomendasi',
        'tanggal_pengajuan',
        'tanggal_persetujuan',
        'keterangan',
        'status'
    ];

    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class, 'nim', 'nim');
    }
}
