<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
    use HasFactory;
    protected $table = 'recetas';
    protected $primaryKey ='id';
    protected $fillable = [
        'id_receta',
        'id_producto',
        'cantidad',
        'estado'
    ];
    public $timestamps=false;
  
}
