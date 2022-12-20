<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\Producto;
use App\Models\ProductoAlmacen;
use App\Models\TemporalInventario;
use Illuminate\Http\Request;

class ProductoAlmacenController extends Controller
{
    protected $productos, $temporal_inventario, $producto_almacen;

    public function __construct()
    {
        $this->productos = New Producto;
        $this->temporal_inventario = New TemporalInventario();       
        $this->producto_almacen = New ProductoAlmacen();       
    }

    //PRODUCTO EN ALMACEN(INVENTARIO) - TABLA INTERMEDIA
    public function index()
    {
        $producto_almacen=ProductoAlmacen::select(
            'producto_almacen.id as id_product_almacen',
            'productos.nombre',
            'productos.precio',
            'producto_almacen.stock',
            'almacenes.sigla'
        )
        ->join('productos','producto_almacen.id_producto','=','productos.id')
        ->join('almacenes','producto_almacen.id_almacen','=','almacenes.id')
        ->where('producto_almacen.estado','=',1)
        ->orderBy('producto_almacen.stock','asc')
        ->get();
        //->get(); //DEVUELDE TODOS LOS DATOS
        //->toSql();  //DEVUELVE LA CONSULTA REALIZADA PERO EN COMANDOS

        return view('administracion.inventario.index',compact('producto_almacen'));

    }

    public function create()
    {
        $almacenes = Almacen::all()->where('estado',1);
        $productos = Producto::all()->where('estado',1);
        return view('administracion.inventario.create',compact('almacenes','productos'));
    }

    public function store(Request $request)
    {
        $folio =  $request->id_inventario;
        $datos_del_temporal_inventario = $this->temporal_inventario->TraerDatosTempInv($folio);

        foreach ($datos_del_temporal_inventario as $row) {

            $exite_producto_almacen = $this->producto_almacen->porIdProductoAlmacen($row['id_producto'],$row['id_almacen']);

            if ($exite_producto_almacen) {
                $productoAlmacen = ProductoAlmacen::findOrFail($exite_producto_almacen['id']);
                $productoAlmacen->stock = ($exite_producto_almacen['stock'] + $row['stock']);
                $productoAlmacen->update();
                $this->productos->actualizaStock($row['id_producto'],$row['stock'],'-');
            }else{
                $productoAlmacen = new ProductoAlmacen();
                $productoAlmacen->id_producto = $row['id_producto'];
                $productoAlmacen->id_almacen = $row['id_almacen'];
                $productoAlmacen->stock = $row['stock'];
                $productoAlmacen->save();
                $this->productos->actualizaStock($row['id_producto'],$row['stock'],'-');
            }
        }

        $this->temporal_inventario->vaciar_temporal_inventario();
        return redirect('/administracion/inventario');
    }


    public function buscarporcodigo($id)
    {
        $datos = Producto::findOrFail($id);
        $res['messege']='hola como te llamas';
        $res['id']=$id;
        $res['datos']=$datos;
        return json_encode($res);
    }
    



}
