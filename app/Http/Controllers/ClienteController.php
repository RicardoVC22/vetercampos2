<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Models\User;

class ClienteController extends Controller
{
 
    protected $clientes;
    public function __construct()
    {
        $this->clientes=new Cliente();
    }
    public function index()
    {
      $datos=$this->clientes->where('estado',1)->get();
      $usuario= User::all();
      $dato= ['cliente'=> $datos,'usuario'=>$usuario];
      //return $datos;
     // return $usuario;
      return view('administracion/clientes/index',$dato);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Cliente $clientes)
    {
        //
    }
    public function eliminados()
    {
        $datos=$this->clientes->where('estado',0)->get();
        $usuario= User::all();
        $dato= ['cliente'=> $datos,'usuario'=>$usuario];
        //return $datos;
       // return $usuario;
        echo view('administracion/clientes/eliminados',$dato);
    }

    public function restaurar(Cliente $cliente)
    {
      $cliente->estado=1;
      $cliente->update();
      return  redirect()->to(asset('administracion/cliente'));
    }

    public function edit($id)
    {
       // return $clientes;
        $usuario= User::all();
        $clientes=Cliente::all();
        $clientes=$clientes->where('id_usuario',$id)->first();
       // $usuario= $this->usuario->where('id',$clientes->id_usuario);
        $dato = ['cliente'=>$clientes,'usuario'=>$usuario];
    
        echo view('administracion/clientes/editar',$dato);
        
    }

    public function update(Request $request, Cliente $cliente)
    {
       // return $clientes;
       //return $request;

       $cliente->nombre=$request->nombre;
       $cliente->edad=$request->edad;
       $cliente->telefono=$request->telefono;
       $cliente->apellidos=$request->apellidos;
       
     //  return 'se actualizo';
       $usuario=User::all();
       $usuario=$usuario->where('id',$cliente->id_usuario)->first();
       $usuario->name=$request->nombre;
       $cliente->update();
       $usuario->update();
       return  redirect()->to(asset('administracion/cliente'));
    }

    public function destroy(Cliente $cliente)
    {
      $cliente->estado=0;
      $cliente->update();
      return  redirect()->to(asset('administracion/cliente'));
    }
}
