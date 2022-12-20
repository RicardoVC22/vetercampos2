<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Empleado;
use App\Models\Repartidor;
use App\Models\Cliente;
use App\Models\ProductoAlmacen;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   $id=Auth::user()->id;
    
        // $productos = Producto::all()->where('estado',1);
        // return view('welcome',compact('productos'));

         $sql = "SELECT SUM(producto_almacen.stock) AS totalstock, productos.id, productos.nombre, productos.descripcion, productos.precio
                 FROM producto_almacen INNER JOIN productos
                 ON producto_almacen.id_producto = productos.id
                 WHERE producto_almacen.estado = 1
                 AND producto_almacen.stock > 0
                 GROUP BY productos.id, productos.nombre, productos.descripcion, productos.precio;";

         $productos = DB::select($sql);
       
        //  $sql = 'SELECT * FROM products';
        //  ->distinct()->get();  
        $categorias=ProductoAlmacen::select(
            'categorias.nombre',
            'categorias.id'
            )
            ->join('almacenes','producto_almacen.id_almacen','=','almacenes.id')
            ->join('productos','producto_almacen.id_producto','=','productos.id')
            ->join('categorias','productos.id_categoria','=','categorias.id')
            ->where('producto_almacen.estado','=',1)
            ->where('producto_almacen.stock','>',0)
            ->distinct()->get();
    
        $almacenes=ProductoAlmacen::select(
           'almacenes.sigla'
        )
        ->join('almacenes','producto_almacen.id_almacen','=','almacenes.id')
        ->join('productos','producto_almacen.id_producto','=','productos.id')
        ->where('producto_almacen.estado','=',1)
        ->distinct()->get(); 
        return view('welcome',compact('productos','categorias','almacenes'));
    }

    public function perfil(User $user)
    {   
        $cliente = Cliente::all()->where('id_usuario',$user->id)->first();
        $repartidor = Repartidor::all()->where('id_usuario',$user->id)->first();
        $empleado = Empleado::all()->where('id_usuario',$user->id)->first();

        if($cliente!=null){
            $nombre=$cliente->nombre;
            $apellidos=$cliente->apellidos;
            $edad=$cliente->edad;
            $telefono=$cliente->telefono;
            $licencia="";
            $direccion="";
            $sueldo="";
        }
        if($empleado!=null){
            $nombre=$empleado->nombre;
            $apellidos=$empleado->apellidos;
            $edad=$empleado->edad;
            $telefono=$empleado->telefono;
            $licencia="";
            $direccion=$empleado->direccion;
            $sueldo=$empleado->sueldo;
        }
        if($repartidor!=null){
            $nombre=$repartidor->nombre;
            $apellidos=$repartidor->apellidos;
            $edad=$repartidor->edad;
            $telefono=$repartidor->telefono;
            $licencia=$repartidor->nro_licencia;
            $direccion="";
            $sueldo="";
        }
        

        return view('perfil',compact('nombre','apellidos','edad','telefono','licencia','direccion','sueldo'));
    }

    public function perfilupdate(User $user , Request $request)
    {   
        $cliente = Cliente::all()->where('id_usuario',$user->id)->first();
        $repartidor = Repartidor::all()->where('id_usuario',$user->id)->first();
        $empleado = Empleado::all()->where('id_usuario',$user->id)->first();

        if($cliente!=null){
            $cliente->nombre=$request->nombre;
            $cliente->apellidos=$request->apellidos;
            $cliente->edad=$request->edad;
            $cliente->telefono=$request->telefono;
            $cliente->update();
        }
        if($empleado!=null){
            $empleado->nombre=$request->nombre;
            $empleado->apellidos=$request->apellidos;
            $empleado->edad=$request->edad;
            $empleado->telefono=$request->telefono;
            $empleado->direccion=$request->direccion;
            $empleado->update();
        }
        if($repartidor!=null){
          $repartidor->nombre=$request->nombre;
          $repartidor->apellidos=$request->apellidos;
          $repartidor->edad=$request->edad;
          $repartidor->telefono=$request->telefono;
          $repartidor->update();
        }
        $user->name=$request->nombre;
        $user->update();
        return  redirect()->to(asset('/'));
    }

    public function editpassword()
    {
        return view('vendor/adminlte/auth/passwords/reset');
    }


    public function confirmarpassword(User $user , Request $request)
    {
      
       
    }

    public function perfilupdatepassword(User $user , Request $request)
    {

     if (Hash::check($request->contraseña,$user->password)){
        if($request->nueva_contraseña == $request->confirmar_nueva_contraseña){
            if (Hash::check($request->nueva_contraseña,$user->password)){
                return 'no puede ingresar lo mismo';   
            }else{
                $user->password=Hash::make($request->nueva_contraseña);
                $user->update();
                return  redirect()->to(asset('/'));
            }
        }else{
            return 'son diferentes contraseñas ingresadas';
        }
     }else{
        return 'disculpe su contraseña actual no esta correcta intente de nuevo';
     }
        
    }


}
