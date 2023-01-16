<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Mascota;
use Illuminate\Http\Request;
use Illuminate\Support\Str; //Extencion para importar imagen
use Illuminate\Support\Facades\File;//extencion para eliminar imagen

class MascotaController extends Controller
{
    public function index()
    {
        $clientes= Cliente::all()->where('estado',1);
        $mascotas = Mascota::all()->where('estado',1);
        return view('mascotas.index',compact('mascotas','clientes'));
    }

    public function create()
    {
        $clientes = Cliente::all()->where('estado',1);
        return view('mascotas.create',compact('clientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'=>'required|max:40',
            'color'=>'required',
            'fecha'=>'required',
            'sexo'=>'required',
            'id_cliente'=>'required',
            'img_mascota' => 'image|mimes:jpg,jpeg|max:2048|min:8'
        ]);

        $mascota = new Mascota();
        $mascota->nombre = $request->nombre;
        $mascota->sexo = $request->sexo;
        $mascota->color = $request->color;
        $mascota->raza = $request->raza;
        $mascota->fecha_nac = $request->fecha;
        $mascota->id_cliente = $request->id_cliente;
        $mascota->save();
        
        //script para subir una imagen
        if ($request->hasFile("img_mascota")) {//existe un campo de tipo file?
            $imagen = $request->file("img_mascota"); //almacenar imagen en variable
            $nombreimagen = Str::slug($mascota->id).".".$imagen->guessExtension();//insertar parametro del nombre de imagen
            $ruta = public_path("img/mascotas/");//guardar en esa ruta
            $imagen->move($ruta,$nombreimagen); //mover la imagen es esa ruta y con ese nombre

            //copy($imagen->getRealPath(),$ruta.$nombreimagen); copiar imagen un una ruta
        }

        return redirect('mascota');
    }

    public function edit($id)
    {
        $clientes= Cliente::all()->where('estado',1);
        $mascota = Mascota::findOrFail($id);
        

        return view('mascotas.editar',compact('mascota','clientes'));

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre'=>'required|max:40',
            'color'=>'required',
            'fecha'=>'required',
            'sexo'=>'required',
            'id_cliente'=>'required',
            'img_mascota' => 'image|mimes:jpg,jpeg|max:2048|min:8'
        ]);

        $mascota = Mascota::findOrFail($id);
        $mascota->nombre = $request->nombre;
        $mascota->sexo = $request->sexo;
        $mascota->color = $request->color;
        $mascota->raza = $request->raza;
        $mascota->fecha_nac = $request->fecha;
        $mascota->id_cliente = $request->id_cliente;
        $mascota->update();

        //script para subir editar una imagen
        if ($request->hasFile("img_mascota")) {
            $image_path = public_path("img/mascotas/{$request->id}.jpg");
            if (File::exists($image_path)) {
                File::delete($image_path);  //eliminar imagen existente
            }
            $imagen = $request->file("img_mascota");
            $nombreimagen =  $request->id.".jpg";
            $ruta = public_path("img/mascotas/");
            $imagen->move($ruta,$nombreimagen);
        }
        return redirect('mascota');
    }

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->estado = 0;
        $producto->update();
        $productos = Producto::all()->where('estado',1);
        return view('productos.index',compact('productos'));
    }

    public function deletes()
    {
        $productos = Producto::all()->where('estado',0);
        return view('productos.eliminados',compact('productos'));
    }

    public function restore($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->estado = 1;
        $producto->update();
        return redirect('/producto');//IR A ESA RUTA
    }

}
