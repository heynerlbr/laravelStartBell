<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class elementos_reservas extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_elemento',
        'fecha_inicio',
        'fecha_fin',
        'hora_inicio',
        'hora_fin',
        'id_usuario_crea',
        'estado',
        'id_usuario_reserva',
        'id_empresa'       
    ];

    public $timestamps = false;
}
