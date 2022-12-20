<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::all()->where('estado',1);
        return view('categorias.index',compact('categorias'));
    }

    public function create()
    {
        return view('categorias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'=>'required|max:30',
        ]);
        $categoria = new Categoria();
        $categoria->nombre = $request->nombre;
        $categoria->save();
        return redirect('/categoria'); //IR A ESA RUTA
    }

    public function edit($id)
    {
        $categoria = Categoria::findOrFail($id);
        return view('categorias.editar',compact('categoria'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre'=>'required|max:30',
        ]);
        $producto = Categoria::findOrFail($id);
        $producto->nombre = $request->nombre;
        $producto->update();
        return redirect('/categoria');//IR A ESA RUTA
    }


    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->estado = 0;
        $categoria->update();
        $categorias = Categoria::all()->where('estado',1);
        return view('categorias.index',compact('categorias'));
    }

    public function deletes()
    {
        $categorias = Categoria::all()->where('estado',0);
        return view('categorias.eliminados',compact('categorias'));
    }

    public function restore($id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->estado = 1;
        $categoria->update();
        return redirect('/categoria');//IR A ESA RUTA
    }
}
