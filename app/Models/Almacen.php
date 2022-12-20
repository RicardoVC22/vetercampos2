<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    use HasFactory;
    protected $table = 'almacenes';
    protected $primaryKey ='id';
    protected $fillable = [
        'sigla',
        'capacidad',
        'estado'
    ];
    public $timestamps=false;
}
