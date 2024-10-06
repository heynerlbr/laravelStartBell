<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class favoritos extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'lugar_id',      
    ];

    public $timestamps = false;
    
    public function lugar()
    {
        return $this->belongsTo(Lugares::class, 'lugar_id');
    }
}
