<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class referensi extends Model
{

    use HasFactory;

    protected $table = 'referensi';

    protected $fillable = [
        'id_referensi',
        'buku_referensi',
    ];

    public function Rps()
    {
        return $this->belongsTo(Rps::class, 'id_referensi');
    }
}
