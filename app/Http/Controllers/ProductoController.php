<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\ingrediente;
use App\Models\Producto;
use App\Models\Receta;
use Illuminate\Http\Request;
use Illuminate\Support\Str; //Extencion para importar imagen
use Illuminate\Support\Facades\File;//extencion para eliminar imagen
// use Illuminate\Support\Facades\StorageNews
// Storage::disk('public')->delete("images/news/{$news->file_name}");
class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::all()->where('estado',1);
        return view('productos.index',compact('productos'));
    }

    public function create()
    {
        $categorias = Categoria::all()->where('estado',1);
        return view('productos.create',compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'=>'required|max:40',
            'descripcion'=>'required',
            'precio'=>'required',
            'id_categoria'=>'required',
            'img_producto' => 'image|mimes:jpg,jpeg|max:2048|min:8'
        ]);

        $producto = new Producto();
        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->precio = $request->precio;
        $producto->id_categoria = $request->id_categoria;
        $producto->save();
        
        //script para subir una imagen
        if ($request->hasFile("img_producto")) {//existe un campo de tipo file?
            $imagen = $request->file("img_producto"); //almacenar imagen en variable
            $nombreimagen = Str::slug($producto->id).".".$imagen->guessExtension();//insertar parametro del nombre de imagen
            $ruta = public_path("img/productos/");//guardar en esa ruta
            $imagen->move($ruta,$nombreimagen); //mover la imagen es esa ruta y con ese nombre

            //copy($imagen->getRealPath(),$ruta.$nombreimagen); copiar imagen un una ruta
        }

        return redirect('producto');
    }

    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        $categorias = Categoria::all()->where('estado',1);

        return view('productos.editar',compact('producto','categorias'));

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre'=>'required|max:40',
            'descripcion'=>'required',
            'precio'=>'required',
            'id_categoria'=>'required',
            'img_producto' => 'image|mimes:jpg,jpeg|max:2048|min:8'
        ]);

        $producto = Producto::findOrFail($id);
        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->precio = $request->precio;
        $producto->id_categoria = $request->id_categoria;
        $producto->update();

        //script para subir editar una imagen
        if ($request->hasFile("img_producto")) {
            $image_path = public_path("img/productos/{$request->id}.jpg");
            if (File::exists($image_path)) {
                File::delete($image_path);  //eliminar imagen existente
            }
            $imagen = $request->file("img_producto");
            $nombreimagen =  $request->id.".jpg";
            $ruta = public_path("img/productos/");
            $imagen->move($ruta,$nombreimagen);
        }
        return redirect('producto');
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



    public function receta()
    {   $productos= Producto::all()->where('recetado',0);
       // return $productos;
        $ingredientes = ingrediente::all()->where('estado',1);
        return view('productos.receta',compact('ingredientes','productos'));
    }
    public function generar(Request $request)
    {
        $num=collect($request->receta);
        $n=count($num);

      //  return $n;

     //  echo "sw = ".$num[0]."  id_ingrediente =".$num[1]."  cantidad = ".$num[2]."  unidad = ".$num[3].'<br>';
     //  echo "sw = ".$num[4]."  id_ingrediente =".$num[5]."  cantidad = ".$num[6]."  unidad = ".$num[7].'<br>';
     //  echo "sw = ".$num[8]."  id_ingrediente =".$num[9]."  cantidad = ".$num[10]."  unidad = ".$num[11].'<br>';
      // echo "sw = ".$num[12]."  id_ingrediente =".$num[13]."  cantidad = ".$num[14]."  unidad = ".$num[15].'<br>';
    //  return $num;
    $i=0;
    $p=0;
    while ($i < $n){
      if($num[$i]==1){$p=$p+1;}  
      $i=$i+4;
    }
        if($p != 0){
            $i=0;
            while ($i<$n) {
                if($num[$i]==1){
                $receta=new Receta();
                $receta->id_ingrediente=$num[$i+1];
                $receta->cantidad=$num[$i+2];
                $receta->unidad=$num[$i+3];
                $receta->id_producto=$request->id_producto;
                $receta->save();
                }
            $i=$i+4;
            }
            // cuando acabe actualizar producto porq ya esta recetedo
            $producto = Producto::findOrFail($request->id_producto);
            $producto->recetado = 1;
            $producto->update();
            
            return redirect('producto');
        }else{
            return "no selecciono ningun";
        }

    }

    public function detallereceta(Producto $producto){
         $detalle= Receta::all()->where('estado',1);
         $detalle=$detalle->where('id_producto',$producto->id);
         $ingredientes = ingrediente::all();
         $id_producto=$producto->id;
        // return $detalle;
          $n=count($detalle);
         //return $n;
         if($n!=0){
            return view('productos/detallereceta',compact('ingredientes','detalle','id_producto'));
         }else {
            return "lo siento no tiene creado una receta";
         }
    } 

    public function destroyreceta(Producto $producto)
    {
       // $detalle= Receta::all()->where('id_producto',$producto->id);

       // return $detalle;
        Receta::where('id_producto',$producto->id)->delete();
     //   $detalle->delete();
        $producto->recetado=0;
        $producto->update();
       return redirect('/producto');
    }
    
}
