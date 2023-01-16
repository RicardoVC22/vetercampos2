<?php

namespace App\Http\Controllers;

use App\Models\Tipo_Servicio;
use Illuminate\Http\Request;

class TipoServicioController extends Controller
{
    public function index()
    {
        $tipo_servicios = Tipo_Servicio::all()->where('estado',1);
        return view('tipo_servicios.index',compact('tipo_servicios'));
    }

    public function create()
    {
        return view('tipo_servicios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'=>'required|max:30',
            'descripcion'=>'required'
        ]);
        $tipo_servicio = new Tipo_Servicio();
        $tipo_servicio->nombre = $request->nombre;
        $tipo_servicio->descripcion = $request->descripcion;
        $tipo_servicio->save();
        return redirect('tipo_servicio'); //IR A ESA RUTA
    }

    public function edit($id)
    {
        $tipo_servicio = Tipo_Servicio::findOrFail($id);
        return view('tipo_servicios.editar',compact('tipo_servicio'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre'=>'required|max:30',
            'descripcion'=>'required'
        ]);
        $tipo_servicio = Tipo_Servicio::findOrFail($id);
        $tipo_servicio->nombre = $request->nombre;
        $tipo_servicio->descripcion = $request->descripcion;
        $tipo_servicio->update();
        return redirect('tipo_servicio');//IR A ESA RUTA
    }


    public function destroy($id)
    {
        $tipo_servicio = Tipo_Servicio::findOrFail($id);
        $tipo_servicio->estado = 0;
        $tipo_servicio->update();
        $tipo_servicios = Tipo_Servicio::all()->where('estado',1);
        return view('tipo_servicios.index',compact('tipo_servicios'));
    }

    public function deletes()
    {
        $tipo_servicios = Tipo_Servicio::all()->where('estado',0);
        return view('tipo_servicios.eliminados',compact('tipo_servicios'));
    }

    public function restore($id)
    {
        $tipo_servicio = Tipo_Servicio::findOrFail($id);
        $tipo_servicio->estado = 1;
        $tipo_servicio->update();
        return redirect('tipo_servicio');//IR A ESA RUTA
    }
}
