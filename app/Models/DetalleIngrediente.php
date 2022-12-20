<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleIngrediente extends Model
{
    use HasFactory;
    

    protected $table = 'detalle_ingrediente';
    protected $primaryKey ='id';
    protected $fillable = [
        'id_produccion',
        'id_ingrediente',
        'cantidad'
    ];
    public $timestamps=false;

}
