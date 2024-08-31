<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class elementos_imagenes extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'url',
        'extension',
        'tamano',
        'fecha_crea',
        'id_usuario_crea',
        'id_elemento',
        'imagen_principal'
    ];

    public $timestamps = false;
}
