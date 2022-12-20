<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleProduccion extends Model
{
    use HasFactory;

    protected $table = 'detalle_produccion';
    protected $primaryKey ='id';
    protected $fillable = [
        'id_producto',
        'id_produccion',
        'cantidad',
    ];
    public $timestamps=false;
}
