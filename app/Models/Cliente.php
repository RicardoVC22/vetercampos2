<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $table = 'clientes';
    protected $primaryKey ='id';
    protected $fillable = [
        'nombre',
        'apellidos',
        'edad',
        'estado',
        'telefono',
        'id_usuario',
        'estado',
    ];
    public $timestamps=true;
}
