<?php

namespace App\Http\Controllers;

use App\Models\provedor;
use Illuminate\Http\Request;
use App\Models\ppersona;
use App\Models\pempresa;


class ProvedorController extends Controller
{
   
    public function index()
    {
        $provedor1= provedor::all()->where('estado',1);
        $provedor2= provedor::all()->where('estado',1);
        $ppersona= ppersona::all();
        $pempresa= pempresa::all();

        return view('provedores/index',compact('provedor1','provedor2','ppersona','pempresa'));
    }

   
    public function create()
    {
        return view('provedores/create');
    }

    
    public function store(Request $request)
    {
       // return $request;
        $request->validate([
            'direccion'=>'required|max:30',
            'telefono'=>'required|max:8',
            'correo'=>'required|max:30|email',
        ]);

        $provedor=  new provedor();
      //  return $provedor;
        $provedor->direccion=$request->direccion;
        $provedor->telefono=$request->telefono;
        $provedor->correo=$request->correo;
       // return $request;
        if ($request->opcion==1){
            $request->validate([
                'nombre'=>'required|max:30',
                'apellido'=>'required|max:30',
            ]);

            $provedor->save();
           // return $provedor;
            $ppersona = new ppersona();
            $ppersona->id=$provedor->id;
            $ppersona->nombre=$request->nombre;
            $ppersona->apellidos=$request->apellido;
            $ppersona->save();
        }
        if ($request->opcion==2){
            $request->validate([
                'razon_social'=>'required|max:30',
            ]);

            $provedor->save();
            $pempresa = new pempresa();
            $pempresa->razonsocial=$request->razon_social;
            $pempresa->id=$provedor->id;
            $pempresa->save();
        }
        return redirect()->to(asset('provedor'));
    }


    public function show(provedor $provedor)
    {
        //
    }

    
    public function edit(provedor $provedor,$sw)
    {
        if ($sw==1){ // es persona
        $persona = ppersona::findOrFail($provedor->id);
        $tipo=1;//referencia a persona
        return view('provedores/editar',compact('persona','tipo','provedor'));

       // return view('categorias.editar',compact('provedor'));
        }
        if ($sw==0){ // es empresa
        $empresa = pempresa::findOrFail($provedor->id);
        $tipo=0;  //referente a empresa
        return view('provedores/editar',compact('empresa','tipo','provedor'));

        }
    }

    public function deletes()
    {
        $provedor1= provedor::all()->where('estado',0);
        $provedor2= provedor::all()->where('estado',0);
        $ppersona= ppersona::all();
        $pempresa= pempresa::all();

        return view('provedores/eliminados',compact('provedor1','provedor2','ppersona','pempresa'));
    }

   
    public function update(Request $request, provedor $provedor)
    {
        //return $request;
        $request->validate([
            'direccion'=>'required|max:30',
            'telefono'=>'required|max:30',
            'correo'=>'required|max:30',
        ]);
        $provedor->direccion=$request->direccion;
        $provedor->telefono=$request->telefono;
        $provedor->correo=$request->correo;
        $provedor->update();
       // return $request;
        if ($request->tipo==1){
            $request->validate([
                'nombre'=>'required|max:30',
                'apellido'=>'required|max:30',
            ]);

            
            $ppersona = ppersona::findOrFail($provedor->id);
            $ppersona->nombre=$request->nombre;
            $ppersona->apellidos=$request->apellido;
            $ppersona->update();
        }
        if ($request->tipo==0){
            $request->validate([
                'razon_social'=>'required|max:30',
            ]);

            $pempresa = pempresa::findOrFail($provedor->id);
            $pempresa->razonsocial=$request->razon_social;
            $pempresa->update();
        }
        return redirect()->to(asset('provedor'));
    }

    public function destroy(provedor $provedor)
    {
        $provedor->estado=0;
        $provedor->update();
        return redirect()->to(asset('provedor'));
    }
    public function restore(provedor $provedor)
    {
        $provedor->estado=1;
        $provedor->update();
        return redirect()->to(asset('provedor'));
    }
}
