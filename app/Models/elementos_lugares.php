<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class elementos_lugares extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_lugar',
        'nombre',
        'numero_capacidad',
        'hora_inicio_disponibilidad',
        'hora_fin_disponibilidad',
        'lunes',
        'martes',
        'miercoles',
        'jueves',
        'viernes',
        'sabado',
        'domingo',
        'descripcion',
        'id_reservable',
        'fecha_modifica',
        'url_imagen',
        'fecha_crea',
        'valor'    
    ];
    public $timestamps = false;
}
