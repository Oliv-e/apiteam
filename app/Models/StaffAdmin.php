<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffAdmin extends Model
{
    use HasFactory;
    protected $table = 'admin';
    protected $fillable = [
        'id_admin',
        'nama',
        'no_hp'
    ];
}


