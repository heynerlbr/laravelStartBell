<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class empresas_sistemas extends Model
{
    use HasFactory;
    protected $fillable = [
        'identificacion',
        'nombre',
        'idUsuarioCrea',  
        'img'       
    ];

    public $timestamps = false;
}
