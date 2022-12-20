<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoAlmacen extends Model
{
    use HasFactory;
    
    protected $table = 'producto_almacen';
    protected $primaryKey ='id';
    protected $fillable = [
        'id_producto',
        'id_almacen',
        'stock',
        'estado'
    ];
    public $timestamps=false;

    public function porIdProductoAlmacen($id_producto,$id_almacen){
        $datos=$this->select('*')->where('id_producto','=',$id_producto)->where('id_almacen','=',$id_almacen)->get()->first(); 
        return $datos;
    }
    //BUSCA EL ID DE PRODUCTO ALMACEN DE UN PRODUCTO, ES DECIR BUSCA EL ALMACEN DEL PRODUCTO
    public function buscar_mi_almacen($id_producto, $cantidad)
    {
        $id_inventario =$this->select('id')->where('id_producto','=',$id_producto)->where('stock','>','0')->where('stock','>=',$cantidad)->where('estado','=','1')->get()->first();
        return $id_inventario;
    }

    public function actualizaStockProductoAlmacen($id_productodealmacen,$id_producto, $cantidad, $operador='+')
    {
        //buscar el "producto_almacen" del cual su stock se mayor a la $cantidad dada segun el "id" de un producto
        $producto_almacen = $this->findOrFail($id_productodealmacen);
        if( $operador == '+'){
            $stock_actualizado = $producto_almacen->stock + $cantidad;
        }else{
            $stock_actualizado = $producto_almacen->stock - $cantidad;
        }
        if($producto_almacen->stock >= $stock_actualizado){
            $producto_almacen->stock = $stock_actualizado;
            $producto_almacen->update();
        }else{
            
            
            // $id_prod_alm = $this->id_prod_alm($id_producto);
           
            // foreach ($id_prod_alm as $row) {
            
            //     if ($row['id']) {
            //     $productoAlmacen = ProductoAlmacen::findOrFail($row['id']);
            //     $productoAlmacen->stock = '0';
            //     $productoAlmacen->update();
            //     }
            // }
          
        }

    
       
    }

    public function id_prod_alm($id_producto)
    {
        $datos =$this->select('*')->where('id_producto','=',$id_producto)->where('stock','>','0')->where('estado','=','1')->get();
        return $datos;
    }
    public function id_inventario($id_producto){
        $datos=$this->select('*')->where('id','=',$id_producto)->where('stock','>','0')->get()->first(); 
        return $datos;
    }


}
