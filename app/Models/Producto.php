<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';
    protected $primaryKey ='id';
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'recetado',
        'estado',
        'id_categoria'
    ];
    public $timestamps=false;

    public function actualizaStock($id_producto, $cantidad, $operador='+')
    {
        $producto = $this->findOrFail($id_producto);
        if( $operador == '+'){
            $stock_actualizado = $producto->stock + $cantidad;
        }else{
            $stock_actualizado = $producto->stock - $cantidad;
        }
        $producto->stock = $stock_actualizado;
        $producto->update();
    }
}
