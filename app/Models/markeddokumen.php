<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class markeddokumen extends Model
{
    use HasFactory;
    protected $table = 'user';
    protected $fillable = [
        'id_tandai',
        'id_user',
        'id_kategori',
        'marked_at'
    ];
}


