<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repartidor extends Model
{
    use HasFactory;

    protected $table = 'repartidores';
    protected $primaryKey ='id';
    protected $fillable = [
        'nombre',
        'apellidos',
        'telefono',
        'nro_licencia',
        'estado',
        'id_usuario'
    ];
    public $timestamps=false;
}
