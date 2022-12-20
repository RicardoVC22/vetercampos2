<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\User;
use App\Models\Repartidor;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class RepartidorController extends Controller
{
    

    public function index()
    {
     $repartidores = Repartidor::all()->where('estado',1);
     $usuarios=User::all()->where('estado',1);
     return view('administracion/repartidores/index',compact('repartidores','usuarios'));
    }

    public function solucitudpedidos()
    {
        $userId = auth()->user()->id;
        $repartidores = Repartidor::all();
        $id_repartidor=$repartidores->where('id_usuario',$userId)->first();
      
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
        ->join('repartidores','pedidos.id_repartidor','=','repartidores.id')
        ->join('empleados','pedidos.id_empleado','=','empleados.id')
        ->where('pedidos.estado','=',1)
        ->where('pedidos.id_repartidor','=', $id_repartidor['id'])
        ->orderBy('pedidos.id','desc')
        ->get();

        return view('administracion.repartidores.pedidos-solicitados',compact('pedidos'));
        
    }

    public function cambiarestado(Request $request)
    {
        $request->validate([
            'id_pedido'=> 'required|numeric',
            'estado'=> 'required',
        ]);

        $pedido = Pedido::findOrFail($request->id_pedido);
        if ($request->estado == 'cancelado') {
            $pedido->estadodelpedido = $request->estado;
            $pedido->id_empleado = NULL;
            $pedido->id_repartidor = NULL;
        }else{
            $pedido->estadodelpedido = $request->estado;
        }
        $pedido->update();
        return back();
    }

    public function create()
    {
      return view('administracion/repartidores/create');
    }

    public function store(Request $request)
    {
        //return $request;
        $request->validate([
            'nombre'=> 'required',
            'email'=> 'required',
            'contraseña'=> 'required',
            'confirmar_contraseña'=> 'required',
            'apellidos'=> 'required',
            'edad'=> 'required',
            'nro_licencia'=> 'required',
            'telefono'=> 'required',
        ]);

        $usuario= new User();
        $usuario->name=$request->nombre;
        $usuario->email=$request->email;
        $usuario->password=Hash::make($request->contraseña);
        $usuario->save();
        $usuario->assignRole('Repartidor'); // rol por defecto que se asignara a un repartidor

        $repartidor= new Repartidor();
        $repartidor->nombre=$request->nombre;
        $repartidor->apellidos=$request->apellidos;
        $repartidor->edad=$request->edad;
        $repartidor->telefono=$request->telefono;
        $repartidor->nro_licencia=$request->nro_licencia;
        $repartidor->id_usuario=$usuario->id;
        $repartidor->save();
        return  redirect()->to(route('repartidor'));
    }

    public function show(Repartidor $repartidor)
    {
        //
    }

    public function restore(Repartidor $repartidor)
    {
        $usuario=User::all();
        $usuario=$usuario->where('id',$repartidor->id_usuario)->first();
        $usuario->estado=1;
        $repartidor->estado=1;
        $repartidor->update();
        $usuario->update();
        return  redirect()->to(route('repartidor'));
    }

    public function deletes()
    {
        $repartidores = Repartidor::all()->where('estado',0);
        $usuarios=User::all()->where('estado',0);
        return view('administracion/repartidores/eliminados',compact('repartidores','usuarios'));
    }

    public function edit(Repartidor $repartidor)
    {
        $usuario= User::all(); 
        return view('administracion/repartidores/editar',compact('repartidor','usuario'));
    }


    public function update(Request $request, Repartidor $repartidor)
    {
        $repartidor->nombre=$request->nombre;
        $repartidor->edad=$request->edad;
        $repartidor->telefono=$request->telefono;
        $repartidor->apellidos=$request->apellidos;
        $repartidor->nro_licencia=$request->nro_licencia;
        
      //  return 'se actualizo';
        $usuario=User::all();
        $usuario=$usuario->where('id',$repartidor->id_usuario)->first();
        $usuario->name=$request->nombre;
        $repartidor->update();
        $usuario->update();
        return  redirect()->to(route('repartidor'));
    }

    public function destroy(Repartidor $repartidor)
    {
        $usuario=User::all();
        $usuario=$usuario->where('id',$repartidor->id_usuario)->first();
        $usuario->estado=0;
        $repartidor->estado=0;
        $repartidor->update();
        $usuario->update();
        return  redirect()->to(route('repartidor'));

    }
}
