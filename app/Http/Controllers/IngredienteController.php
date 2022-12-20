<?php

namespace App\Http\Controllers;

use App\Models\ingrediente;
use App\Models\provedor;
use App\Models\ppersona;
use App\Models\pempresa;
use Illuminate\Http\Request;

class IngredienteController extends Controller
{
    
    public function index()
    {
        $ingredientes = ingrediente::all()->where('estado',1);
        $provedores = provedor::all()->where('estado',1);
        $personas = ppersona::all();
        $empresas = pempresa::all();
        return view('ingredientes.index',compact('ingredientes','provedores','personas','empresas'));
    }

    public function create()
    {
        $provedores = provedor::all()->where('estado',1);
        $personas = ppersona::all();
        $empresas = pempresa::all();
        return view('ingredientes.create',compact('provedores','personas','empresas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'=>'required|max:40',
            'descripcion'=>'required',
            'id_provedor'=>'required',
    
        ]);
        $ingrediente = new ingrediente();
        $ingrediente->nombre = $request->nombre;
        $ingrediente->descripcion = $request->descripcion;
        $ingrediente->id_provedor= $request->id_provedor;
        $ingrediente->save();
        return redirect('ingrediente');
    }

    public function edit(ingrediente $ingrediente)
    {
    
        $provedores = provedor::all()->where('estado',1);
        $personas = ppersona::all();
        $empresas = pempresa::all();

        return view('ingredientes.editar',compact('ingrediente','provedores','personas','empresas'));

    }

    public function update(Request $request, ingrediente $ingrediente)
    {
        $request->validate([
            'nombre'=>'required|max:40',
            'descripcion'=>'required',
            'id_provedor'=>'required',
        ]);
        $ingrediente->nombre = $request->nombre;
        $ingrediente->descripcion = $request->descripcion;
        $ingrediente->id_provedor = $request->id_provedor;
        $ingrediente->update();
        return redirect('ingrediente');
    }

    public function destroy(ingrediente $ingrediente)
    {
        $ingrediente->estado = 0;
        $ingrediente->update();
        return redirect('ingrediente');
    }

    public function deletes()
    {
        $ingredientes = ingrediente::all()->where('estado',0);
        $provedores = provedor::all()->where('estado',1);
        $personas = ppersona::all();
        $empresas = pempresa::all();
        return view('ingredientes.eliminados',compact('ingredientes','provedores','personas','empresas'));
    }

    public function restore(ingrediente $ingrediente)
    {
        $ingrediente->estado = 1;
        $ingrediente->update();
        return redirect('/ingrediente');//IR A ESA RUTA
    }
}
