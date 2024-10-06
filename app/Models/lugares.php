<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lugares extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'nombre', 
        'direccion',  
        'idEmpresa',  
        'idMunicipio',  
        'id_usuario_crea',
        'id_empresa',
    ];

    public $timestamps = false;

    // Relación con el modelo Favorito
    public function favoritos()
    {
        return $this->hasMany(favoritos::class, 'lugar_id');
    }
}
