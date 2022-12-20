<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Models\Producto;
use Cart;

use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function agregar($id)
    {
        $producto = Producto::find($id);
        \Cart::add(
            $producto->id, 
            $producto->nombre, 
            $producto->precio, 
            1,
            // array("urlfoto"=>$producto->urlfoto)
        );
        $var =  count(\Cart::getContent());
        $res['datos'] = $var;
        $res['error'] = $producto;
        return json_encode($res);
    }

    public function leer()
    {
        $var =  count(Cart::getContent());
        $res['datos'] = $var;
        return json_encode($res);
    }
    

    
     public function add(Request $request){
      
      $producto = Producto::find($request->producto_id);
       \Cart::add(
           $producto->id, 
           $producto->nombre, 
           $producto->precio, 
           1,
           // array("urlfoto"=>$producto->urlfoto)
       );
      return back()->with('success',"$producto->nombre ¡se ha agregado con éxito al carrito!");
        // return response()->json(['success'=>'Added new records.']);
    }
    public function cart(){
        // $cliente=Cliente::all();
        $userId = auth()->user()->id;
        
        // $iduser=Auth::user()->id;
        $cliente=Cliente::all();
        $cliente=$cliente->where('id_usuario',$userId)->first();
    // dd( $cliente );

        return view('checkout',compact('cliente'));
    }

    public function update(Request $request){
        \Cart::update($request->id,
            array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $request->quantity
                ),
        ));
        return  back()->with('success',"Producto eliminado con éxito de su carrito.");
    }


    public function removeitem(Request $request) {
        //$producto = Producto::where('id', $request->id)->firstOrFail();
        \Cart::remove([
        'id' => $request->id,
        ]);
        return back()->with('success',"Producto eliminado con éxito de su carrito.");
    }

    public function clear(){
        Cart::clear();
        return back()->with('success',"The shopping cart has successfully beed added to the shopping cart!");
    }

}
