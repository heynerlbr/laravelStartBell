<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class empresas extends Model
{
    use HasFactory;
    protected $fillable = [
        'identificacion',
        'nombre',
        'idUsuarioCrea',         
    ];

    public $timestamps = false;
}
