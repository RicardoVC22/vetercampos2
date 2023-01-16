<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use App\Models\Tipo_Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Str; //Extencion para importar imagen
use Illuminate\Support\Facades\File;//extencion para eliminar imagen

class ServicioController extends Controller
{
    public function index()
    {
        $servicios = Servicio::all()->where('estado',1);
        $tipo_servicios = Tipo_Servicio::all();
        return view('servicios.index',compact('servicios','tipo_servicios'));
    }

    public function create()
    {
        $tipo_servicios = Tipo_Servicio::all()->where('estado',1);
        return view('servicios.create',compact('tipo_servicios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'=>'required|max:40',
            'descripcion'=>'required',
            'precio'=>'required',
            'id_tipo_servicio'=>'required',
            'img_producto' => 'image|mimes:jpg,jpeg|max:2048|min:8'
        ]);

        $servicio = new Servicio();
        $servicio->nombre = $request->nombre;
        $servicio->descripcion = $request->descripcion;
        $servicio->precio = $request->precio;
        $servicio->id_tipo_servicio = $request->id_tipo_servicio;
        $servicio->save();
        
        //script para subir una imagen
        if ($request->hasFile("img_producto")) {//existe un campo de tipo file?
            $imagen = $request->file("img_producto"); //almacenar imagen en variable
            $nombreimagen = Str::slug($servicio->id).".".$imagen->guessExtension();//insertar parametro del nombre de imagen
            $ruta = public_path("img/servicios/");//guardar en esa ruta
            $imagen->move($ruta,$nombreimagen); //mover la imagen es esa ruta y con ese nombre

            //copy($imagen->getRealPath(),$ruta.$nombreimagen); copiar imagen un una ruta
        }

        return redirect('servicio');
    }

    public function edit($id)
    {
        $servicio = Servicio::findOrFail($id);
        $tipo_servicios = Tipo_Servicio::all()->where('estado',1);

        return view('servicios.editar',compact('servicio','tipo_servicios'));

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre'=>'required|max:40',
            'descripcion'=>'required',
            'precio'=>'required',
            'id_tipo_servicio'=>'required',
            'img_servicio' => 'image|mimes:jpg,jpeg|max:2048|min:8'
        ]);

        $servicio = Servicio::findOrFail($id);
        $servicio->nombre = $request->nombre;
        $servicio->descripcion = $request->descripcion;
        $servicio->precio = $request->precio;
        $servicio->id_tipo_servicio = $request->id_tipo_servicio;
        $servicio->update();

        //script para subir editar una imagen
        if ($request->hasFile("img_servicio")) {
            $image_path = public_path("img/servicios/{$request->id}.jpg");
            if (File::exists($image_path)) {
                File::delete($image_path);  //eliminar imagen existente
            }
            $imagen = $request->file("img_servicio");
            $nombreimagen =  $request->id.".jpg";
            $ruta = public_path("img/servicios/");
            $imagen->move($ruta,$nombreimagen);
        }
        return redirect('servicio');
    }

    public function destroy($id)
    {
        $servicio = Servicio::findOrFail($id);
        $servicio->estado = 0;
        $servicio->update();
        $servicios = Servicio::all()->where('estado',1);
        return view('servicios.index',compact('servicios'));
    }

    public function deletes()
    {
        $servicios = Servicio::all()->where('estado',0);
        return view('servicios.eliminados',compact('servicios'));
    }

    public function restore($id)
    {
        $servicio = Servicio::findOrFail($id);
        $servicio->estado = 1;
        $servicio->update();
        return redirect('servicio');//IR A ESA RUTA
    }

    
}
