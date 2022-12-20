<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\Producto;
use App\Models\TemporalInventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
class TemporalInventarioController extends Controller
{
    protected $temporal_inventario;
    
    public function __construct()
    {
        $this->temporal_inventario = new TemporalInventario();
    }

    public function insertar( Request $request){

        $rules=array(
            'id_producto'  =>"required|numeric",
            'id_inventario' =>"required",
            'stock'  =>"required|numeric",
            'id_almacen' =>"required",
        );
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            return [
                'message' => 'error',
                'errors' =>$validator->getMessageBag()->toArray()
            ];
        }
        else{
           
            $error='';
            $id_producto    =   $request->id_producto;
            $stock_entrante =   $request->stock;
            $id_inventario  =   $request->id_inventario;
            $id_almacen     =   $request->id_almacen;

            $producto = Producto::findOrFail($id_producto);
            $almacen = Almacen::findOrFail($id_almacen);
            if($producto && $almacen){
              
                $datosExiste = $this->temporal_inventario->porIdProductoAlmacen($id_producto,$id_almacen,$id_inventario);

                if ($datosExiste){
                    $stockactual = $datosExiste->stock + $stock_entrante;
                    $existencias = $producto['stock'];

                    if ($existencias >= $stockactual) {
                        $temporalinv = TemporalInventario::findOrFail($datosExiste->id);
                        $temporalinv->stock = $stockactual;
                        $temporalinv->update();
                      
                    }else{
                        $error = 'Stock máximo seleccionado';
                    }
                  
                }else{
                    $dato = New TemporalInventario();
                    $dato->folio        =   $id_inventario;
                    $dato->id_producto  =   $id_producto;
                    $dato->id_almacen   =   $id_almacen;
                    $dato->almacen      =   $almacen['sigla'];
                    $dato->producto     =   $producto['nombre'];
                    $dato->descripcion  =   $producto['descripcion'];
                    $dato->precio       =   $producto['precio'];
                    $dato->stock        =   $stock_entrante;
                    $dato->save();
                }

            }else{
                $error = 'No existe el producto';
            }
           
        $res['datos'] = $this->cargaProductosenAlmacen($id_inventario);
   
        $res['error'] = $error;

        return json_encode($res);
        }

    }

    public function cargaProductosenAlmacen($id_inventario)
    {
        $resultado = $this->temporal_inventario->TraerDatosTempInv($id_inventario);
        $fila = '';
        $numFila = 0;
        foreach ($resultado as $row){
            $numFila++;
            $fila .= "<tr id='fila".$numFila."'>";
            $fila .= "<td>".$numFila."</td>";
            $fila .= "<td>".$row['almacen']."</td>";
            $fila .= "<td>".$row['producto']."</td>";
            $fila .= "<td>".$row['descripcion']."</td>";
            $fila .= "<td>".$row['precio']."</td>";
            $fila .= "<td>".$row['stock']."</td>";
            $fila .= "<td><a role = 'button' onclick=\"eliminaProducto(".$row['id'].")\" class='borrar' ><span  class='fas fa-fw fa-trash'></span></a></td>";
            $fila .= "</tr>";
        }
        return $fila;
    }

    public function eliminar($id)
    {
        $datosExiste = TemporalInventario::findOrFail($id);
      
        if ($datosExiste){
            if ($datosExiste->stock > 1){
                $stockactual= $datosExiste->stock - 1;
                $datosExiste->stock = $stockactual;
                $datosExiste->update();
            }else {
                $datosExiste->delete();
            }
        }
        $res['datos'] = $this->cargaProductosenAlmacen( $datosExiste->folio);
        $res['error']=$datosExiste->folio;
        return json_encode($res);
    }

    public function vaciar()
    {
        TemporalInventario::truncate();
    }
    
}
