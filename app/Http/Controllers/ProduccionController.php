<?php

namespace App\Http\Controllers;
use App\Models\Produccion;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;
use App\Models\DetalleProduccion;
use Illuminate\Http\Request;

class ProduccionController extends Controller
{
    public function index()
    {
        $producciones = Produccion::all()->where('estado',1);
        return view('administracion/producciones/index',compact('producciones'));
    }

    public function create()
    {
        return view('administracion/producciones/create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha'=>'required',
        ]);
        $produccion = new Produccion();
        $produccion->fecha = $request->fecha;
        $produccion->hora = date('H:i:s');
        $produccion->id_usuario=Auth::user()->id;
        $produccion->estadoproduccion = "inactivo";
        $produccion->save();

        return redirect()->to(asset('administracion/produccion')."/".$produccion->id."/".$produccion->fecha);//IR A ESA RUTA
    }

    public function edit(Produccion $produccion)
    {
       // $produccion = Produccion::findOrFail($id);
        return view('administracion/producciones/editar',compact('produccion'));
    }

    public function update(Request $request, Produccion $produccion)
    {
        $request->validate([
            'fecha'=>'required|max:30',
            
        ]);
        $produccion->fecha = $request->fecha;
        $produccion->update();

        return redirect()->route('produccion');//IR A ESA RUTA
    }

    public function destroy(Produccion $produccion)
    {
        //
        $produccion->estado = 0;
        $produccion->update();
        return redirect()->route('produccion');
    }

    public function deletes()
    {
        $producciones = Produccion::all()->where('estado',0);
        return view('administracion/producciones/eliminados',compact('producciones'));
    }

    public function restore($id)
    {
        $produccion = Produccion::findOrFail($id);
        $produccion->estado = 1;
        $produccion->update();
        return redirect()->route('produccion/index');
    }


    public function produccion($id_produccion,$fecha)
    {   
        $productos= Producto::all()->where('recetado',1);
        $fecha_produccion=$fecha;

       // return $productos;
       // return "holaa";
        return view('administracion/producciones/produccion',compact('id_produccion','productos','fecha_produccion'));
    
    }
    public function generar(Request $request, $id_produccion)
    {
        $num=collect($request->detalleproduccion);
        $n=count($num);

        $i=0;
        $p=0;
        while ($i < $n){
          if($num[$i]==1){$p=$p+1;}  
          $i=$i+3;
        }

        if($p != 0){
            $i=0;
            while ($i<$n) {
                if($num[$i]==1){
                $detalleproduccion=new DetalleProduccion();
                $detalleproduccion->id_producto=$num[$i+1];
                $detalleproduccion->cantidad=$num[$i+2];
                $detalleproduccion->id_produccion=$id_produccion;
                $detalleproduccion->save();
                }
            $i=$i+3;
            }
            // cuando acabe actualizar producto porq ya esta recetedo
            $produccion = Produccion::findOrFail($id_produccion);
            $produccion->estadoproduccion = "en proceso";
            $produccion->update();

           // return "registro";
         //   return redirect(asset('administracion/produccion/verproductos').'/'.$id_produccion);
          // return redirect()->route('produccion');
           return redirect()->route('produccion.verdetalle',$id_produccion);
            //dirigimos a su detalle produccion
          //  return redirect()->to(asset('/administracion/produccion/verproductos')."/".$id_produccion);//IR A ESA RUTA
           // return redirect()->to(asset('administracion/produccion')."/".$produccion->id."/".$produccion->fecha);
        }else{
            return "no selecciono ningun";
        }

    }

    public function verdetalle(Produccion $produccion){
        $id_produccion=$produccion->id;
        $estado=$produccion->estadoproduccion;
        $detalle= DetalleProduccion::all();
        $detalle=$detalle->where('id_produccion',$id_produccion);
        $productos = Producto::all();
       // return $detalle;
         $n=count($detalle);
        //return $n;
        if($n!=0){
           //return "hola";
           return view('administracion/producciones/detalleproduccion',compact('productos','detalle','id_produccion','estado'));
        }else {
           return "lo siento no tiene creo su detalle produccion";
        }
    }

    public function destroyproduccion(Produccion $produccion)
    {
       // $detalle= Receta::all()->where('id_producto',$producto->id);

       // return $detalle;
        DetalleProduccion::where('id_produccion',$produccion->id)->delete();
        $produccion->estadoproduccion="inactivo";
        $produccion->update();
     //   $detalle->delete();
      //     $producto->recetado=0;
       // $producto->update();
       return redirect()->route('produccion');
    }

    public function anularproduccion(Produccion $produccion)
    {
       
        $detalles= DetalleProduccion::all()->where('id_produccion',$produccion->id);
        $n=count($detalles);
        if ($n!=0) {
          return "por favor cancele la produccion antes de anular";
        }else{
         // return "si se liminara";
          $produccion->delete();
          return redirect()->route('produccion');
        }
       // $produccion->estadoproduccion="inactivo";
       // $produccion->update();
     //   $detalle->delete();
      //     $producto->recetado=0;
       // $producto->update();
       //return redirect()->route('produccion');
    }

    public function terminarproduccion(Produccion $produccion)
    {
       // $detalle= Receta::all()->where('id_producto',$producto->id);

       // return $detalle;
        $detalles= DetalleProduccion::all()->where('id_produccion',$produccion->id);
      //  return $detalles;
        foreach ($detalles as $detalle) {
            $producto = Producto::findOrFail($detalle->id_producto);
            $producto->stock=$producto->stock + $detalle->cantidad;
            $producto->update();
        }
        $produccion->estadoproduccion="terminado";
        $produccion->horafini=date('H:i:s');
        $produccion->update();
     //   $detalle->delete();
      //     $producto->recetado=0;
       // $producto->update();
       return redirect()->route('produccion');
    }
}
