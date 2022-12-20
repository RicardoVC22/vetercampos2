<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Empleado;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    public function index()
    {
     $empleados = Empleado::all()->where('estado',1);
     $usuarios=User::all()->where('estado',1);
     return view('administracion/empleados/index',compact('empleados','usuarios'));
    }

    public function create()
    {
      $roles = Role::all();
      return view('administracion/empleados/create',compact('roles'));
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
            'id_rol'=> 'required',
            'telefono'=> 'required',
            'sueldo'=> 'required',
            'direccion'=> 'required',
        ]);

        $usuario= new User();
        $usuario->name=$request->nombre;
        $usuario->email=$request->email;
        $usuario->password=Hash::make($request->contraseña);
        $usuario->save();
        $usuario->assignRole($request->id_rol); // rol por defecto que se asignara a un repartidor

        $empleado= new Empleado();
        $empleado->nombre=$request->nombre;
        $empleado->apellidos=$request->apellidos;
        $empleado->edad=$request->edad;
        $empleado->telefono=$request->telefono;
        $empleado->sueldo=$request->sueldo;
        $empleado->direccion=$request->direccion;
        $empleado->id_usuario=$usuario->id;
        $empleado->save();
        return  redirect()->to(route('empleado'));
    }

    public function show(Empleado $empleado)
    {
        //
    }

    public function restore(Empleado $empleado)
    {
        $usuario=User::all();
        $usuario=$usuario->where('id',$empleado->id_usuario)->first();
        $usuario->estado=1;
        $empleado->estado=1;
        $empleado->update();
        $usuario->update();
        return  redirect()->to(route('empleado'));
    }

    public function deletes()
    {
        $empleados = Empleado::all()->where('estado',0);
        $usuarios=User::all()->where('estado',0);
        return view('administracion/empleados/eliminados',compact('empleados','usuarios'));
    }

    public function edit(Empleado $empleado)
    {
        $usuario= User::all(); 
        $roles = Role::all();
        return view('administracion/empleados/editar',compact('empleado','usuario','roles'));
    }


    public function update(Request $request, Empleado $empleado)
    {
        $empleado->nombre=$request->nombre;
        $empleado->edad=$request->edad;
        $empleado->telefono=$request->telefono;
        $empleado->apellidos=$request->apellidos;
        $empleado->sueldo=$request->sueldo;
        $empleado->direccion=$request->direccion;
        
      //  return 'se actualizo';
        $usuario=User::all();
        $usuario=$usuario->where('id',$empleado->id_usuario)->first();
        $usuario->name=$request->nombre;
        $empleado->update();
        $usuario->update();
        return  redirect()->to(route('empleado'));
    }

    public function destroy(Empleado $empleado)
    {
        $usuario=User::all();
        $usuario=$usuario->where('id',$empleado->id_usuario)->first();
        $usuario->estado=0;
        $empleado->estado=0;
        $empleado->update();
        $usuario->update();
        return  redirect()->to(route('empleado'));

    }
}
