<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\DetallePedido;
use App\Models\Empleado;
use App\Models\Pedido;
use App\Models\ProductoAlmacen;
use App\Models\Repartidor;
use App\Models\Ubicacion;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Cart;

class PedidoController extends Controller
{
    protected $producto_almacen;

    public function __construct()
    {
        $this->producto_almacen = New ProductoAlmacen();
    }

    public function index(){
        $repartidores = Repartidor::all()->where('estado',1);
        $pedidos=Pedido::select(
            'pedidos.id',
            'pedidos.fecha',
            'pedidos.montototal',
            'pedidos.estadodelpedido',
            'pedidos.id_ubicacion',
            'pedidos.id_cliente',
            'pedidos.id_empleado',
            'pedidos.id_repartidor',
            'ubicacion.url',
            'clientes.nombre',
            'clientes.apellidos',
            'clientes.telefono',
        )
        ->join('ubicacion','pedidos.id_ubicacion','=','ubicacion.id')
        ->join('clientes','pedidos.id_cliente','=','clientes.id')
        ->where('pedidos.estado','=',1)
        ->orderBy('pedidos.id','desc')
        ->get();

        return view('administracion.pedidos.index',compact('pedidos','repartidores'));
    }

    //PEDIDOS SOLICITADOS DEL CLIENTE:
    public function orders()
    {
        $userId = auth()->user()->id;
        $clientes = Cliente::all();
        $cliente=$clientes->where('id_usuario',$userId)->first();
       
        $pedidos=Pedido::select(
            'pedidos.id',
            'pedidos.fecha',
            'pedidos.montototal',
            'pedidos.estadodelpedido',
            'pedidos.id_ubicacion',
            'pedidos.id_cliente',
            'pedidos.id_empleado',
            'pedidos.id_repartidor',
            'pedidos.created_at',
            'ubicacion.url',
            'ubicacion.referencia',
            'clientes.nombre',
            'clientes.apellidos',
            'clientes.telefono',
        )
        ->join('ubicacion','pedidos.id_ubicacion','=','ubicacion.id')
        ->join('clientes','pedidos.id_cliente','=','clientes.id')
   
        ->where('pedidos.estado','=',1)
        ->where('pedidos.id_cliente','=', $cliente['id'])
        ->orderBy('pedidos.id','asc')
        ->get();
      
        return view('mispedidos',compact('pedidos'));
    }

    public function cancelarsolicitud(Request $request)
    {
        $request->validate([
            'id_pedido'=> 'required|numeric',
        ]);

        $pedido = Pedido::findOrFail($request->id_pedido);
        $pedido->estadodelpedido = 'cancelado';
        $pedido->id_empleado = NULL;
        $pedido->id_repartidor = NULL;
        $pedido->update();
        return back();
    }

    public function store(Request $request){
        $rules=array(
            'id_usuario'  =>"required|numeric",
            'id_cliente' =>"required|numeric",
            'correo'  =>"required|email",
            'apellidos' =>"required",
            'telefono' =>"required",
            'fecha' =>"required",
            'url_ubicacion' =>"required",
            'latitud_y' =>"required",
            'longitud_x' =>"required",
            'referencia' =>"required",
        );

        $validator=Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            return [
                'error' => true,
                'errors' =>$validator->getMessageBag()->toArray()
            ];
        }
        else{
            //RECIBIENDO PARAMETROS DEL FORMULARIO
            $id_usuario     = $request->id_usuario;
            $id_cliente     = $request->id_cliente;
            $correo         = $request->correo;
            $apellidos      = $request->apellidos;
            $telefono       = $request->telefono;
            $fecha          = $request->fecha;
            $url_ubicacion  = $request->url_ubicacion;
            $latitud_y      = $request->latitud_y;
            $longitud_x     = $request->longitud_x;
            $referencia     = $request->referencia;

            //GUARDAR UBICACION
            $ubicacion = new Ubicacion();
            $ubicacion->latitud     =  $latitud_y;
            $ubicacion->longitud    =  $longitud_x ;
            $ubicacion->referencia  =  $referencia;
            $ubicacion->url         =  $url_ubicacion;
            $ubicacion->save();

            //GUARDAR UBICACION
             $id_ubicacion = $ubicacion->id;
             $pedido = new Pedido();
             $pedido->fecha             =  $fecha;
             $pedido->fechaentrega      =  $fecha;
             $pedido->montototal        =   Cart::getTotal();
             $pedido->estadodelpedido   =   'solicitado';
             $pedido->estado            =   1;
             $pedido->id_ubicacion      =   $id_ubicacion;
             $pedido->id_cliente        =   $id_cliente;
             $pedido->id_empleado       =   NULL;
             $pedido->id_repartidor     =   NULL;
             $pedido->save();

            $id_pedido = $pedido->id;
            //GUARDAR DERALLE PEDIDO
            $error =$this->guardardetallepedido( $id_pedido );
            if ($error) {
            
            }else{
                //CONFIRMAR GUARDADO
                // Ubicacion::findOrFail();
            }
            //$res['dato'] =  $this->FunctionName('3','2',4);
            
             $res['error'] = $error;
            return json_encode($res);
        }
    }

    public function guardardetallepedido($id_pedido)
    { 
        try {
            foreach (\Cart::getContent() as $item) {
                $productalmacen = $this->producto_almacen->buscar_mi_almacen($item->id,$item->quantity);
                $detalle_pedido = new DetallePedido();
                $detalle_pedido->id_productodealmacen   = $productalmacen['id'];
                $detalle_pedido->id_pedido              =  $id_pedido ;
                $detalle_pedido->cantidad               =  $item->quantity;
                $detalle_pedido->subtotal               =  $item->getPriceSum();
                $detalle_pedido->save();
                $this->producto_almacen->actualizaStockProductoAlmacen($productalmacen['id'], $item->id ,$item->quantity,'-');
            }
            $error = false;
            Cart::clear();
        } catch (\Throwable $th) {
            $error = true;
        }
        return  $error;
    }

    public function update(Request $request)
    {
        $request->validate([
            'id_pedido'=>'required|numeric',
            'id_repartidor'=>'required|numeric'
        ]);

        $userId = auth()->user()->id;
        $empleado=Empleado::all();
        $empleado=$empleado->where('id_usuario',$userId)->first();
        
        if ($empleado) {
            $pedido = Pedido::findOrFail($request->id_pedido);
            $pedido->id_empleado = $empleado['id'];
            $pedido->id_repartidor = $request->id_repartidor;
            $pedido->estadodelpedido = 'pendiente';
            $pedido->update();
       
        }
        return  back();
    }
    public  function FunctionName($id_productodealmacen, $id_producto, $cantidad)
    {
        $producto_almacen =ProductoAlmacen::findOrFail($id_productodealmacen);
       
        if($producto_almacen->stock >= $cantidad){
            $stock_actualizado = $producto_almacen->stock - $cantidad;
            $producto_almacen->stock = $stock_actualizado;
            $producto_almacen->update();
        }else{
         
        //    $id_prod_alm = $this->producto_almacen->id_prod_alm($id_producto);
        //    foreach ($id_prod_alm as $row) {
        //           if ($row['id']) {
        //           $productoAlmacen = ProductoAlmacen::findOrFail($row['id']);
        //            $productoAlmacen->stock = '0';
        //           $productoAlmacen->update();
        //        }
        //    }
             return "se modifico varios el stocks de registros";
        }
   
    }

}
