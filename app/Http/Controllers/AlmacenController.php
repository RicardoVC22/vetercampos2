<?php

namespace App\Http\Controllers;

use App\Models\Almacen;

use Illuminate\Http\Request;

class AlmacenController extends Controller
{
    public function index()
    {
        $almacenes = Almacen::all()->where('estado',1);
        return view('administracion.almacenes.index',compact('almacenes'));
    }

    public function create()
    {
        return view('administracion.almacenes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'sigla'=>'required|max:30',
            'capacidad'=>'required|numeric',
        ]);
        $almacen = new Almacen();
        $almacen->sigla = $request->sigla;
        $almacen->capacidad = $request->capacidad;
        $almacen->save();

        return redirect()->route('almacen.index');//IR A ESA RUTA
    }

    public function edit($id)
    {
        $almacen = Almacen::findOrFail($id);
        return view('administracion.almacenes.editar',compact('almacen'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'sigla'=>'required|max:30',
            'capacidad'=>'required|numeric',
        ]);
        $almacen = Almacen::findOrFail($id);
        $almacen->sigla = $request->sigla;
        $almacen->capacidad = $request->capacidad;
        $almacen->update();

        return redirect()->route('almacen.index');//IR A ESA RUTA
    }

    public function destroy($id)
    {
        $almacen = Almacen::findOrFail($id);
        $almacen->estado = 0;
        $almacen->update();
        return redirect()->route('almacen.index');
    }

    public function deletes()
    {
        $almacenes = Almacen::all()->where('estado',0);
        return view('administracion.almacenes.eliminados',compact('almacenes'));
    }

    public function restore($id)
    {
        $almacen = Almacen::findOrFail($id);
        $almacen->estado = 1;
        $almacen->update();
        return redirect()->route('almacen.index');
    }
}
