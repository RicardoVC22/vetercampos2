<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    protected $table = 'empleados';
    protected $primaryKey ='id';
    protected $fillable = [
        'nombre',
        'apellidos',
        'edad',
        'sueldo',
        'dirreccion',
        'telefono',
        'estado',
        'id_usuario',
    ];
    public $timestamps=false;
    
}