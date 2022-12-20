<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\ProductoAlmacen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FrontController extends Controller
{
    public function index()
    {
        $sql = "SELECT SUM(producto_almacen.stock) AS totalstock, productos.id, productos.nombre, productos.descripcion, productos.precio
        FROM producto_almacen INNER JOIN productos
        ON producto_almacen.id_producto = productos.id
        WHERE producto_almacen.estado = 1
        AND producto_almacen.stock > 0
        GROUP BY productos.id, productos.nombre, productos.descripcion, productos.precio;";

        $productos = DB::select($sql);
        $categorias=ProductoAlmacen::select(
            'categorias.nombre',
            'categorias.id'
            )
            ->join('almacenes','producto_almacen.id_almacen','=','almacenes.id')
            ->join('productos','producto_almacen.id_producto','=','productos.id')
            ->join('categorias','productos.id_categoria','=','categorias.id')
            ->where('producto_almacen.estado','=',1)
            ->where('producto_almacen.stock','>',0)
            ->distinct()->get();
  
        $almacenes=ProductoAlmacen::select(
            'almacenes.sigla'
         )
         ->join('almacenes','producto_almacen.id_almacen','=','almacenes.id')
         ->join('productos','producto_almacen.id_producto','=','productos.id')
         ->where('producto_almacen.estado','=',1)
         ->distinct()->get(); 
 
         return view('welcome',compact('productos','categorias','almacenes'));
    }

    public function cargarcategoria($id_categoria)
    {
        $sql = "SELECT SUM(producto_almacen.stock) AS totalstock, productos.id, productos.nombre, productos.descripcion, productos.precio
        FROM producto_almacen INNER JOIN productos
        ON producto_almacen.id_producto = productos.id
        WHERE producto_almacen.estado = 1
        AND productos.id_categoria = $id_categoria
        AND producto_almacen.stock > 0
        GROUP BY productos.id,productos.nombre, productos.descripcion, productos.precio;";

        $productos = DB::select($sql);
       
        $almacenes=ProductoAlmacen::select(
        'almacenes.sigla'
        )
        ->join('almacenes','producto_almacen.id_almacen','=','almacenes.id')
        ->join('productos','producto_almacen.id_producto','=','productos.id')
        ->where('producto_almacen.estado','=',1)
        ->distinct()->get();



        // $categorias = Categoria::all()->where('estado',1);
        $categorias=ProductoAlmacen::select(
        'categorias.nombre',
        'categorias.id'
        )
        ->join('almacenes','producto_almacen.id_almacen','=','almacenes.id')
        ->join('productos','producto_almacen.id_producto','=','productos.id')
        ->join('categorias','productos.id_categoria','=','categorias.id')
        ->where('producto_almacen.estado','=',1)
        ->where('producto_almacen.stock','>',0)
        ->distinct()->get();


        return view('welcome',compact('productos','categorias','almacenes'));
    }
}
