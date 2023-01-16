<?php

namespace App\Http\Controllers;

use App\Models\DetalleVenta;
use App\Models\Producto;
use App\Models\ProductoAlmacen;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Cart;
use Codedge\Fpdf\Fpdf\Fpdf;
use Darryldecode\Cart\Cart as CartCart;
use Illuminate\Support\Facades\Auth;

class VentaController extends Controller
{
    protected $producto_almacen;

    public function __construct()
    {
        $this->producto_almacen = New ProductoAlmacen();
    }

    public function index(){
       // $ventas = Venta::all()->where('estado',1);
        $ventas=Venta::select(
            'ventas.*',
            'users.name'    
        )
        ->join('users','ventas.id_usuario','=','users.id')
        ->where('ventas.estado','=',1)
        ->get();

        return view('administracion.ventas.index',compact('ventas'));
    }

    public function nota_venta(){
        $sql = "SELECT SUM(producto_almacen.stock) AS totalstock, productos.id, productos.nombre, productos.descripcion, productos.precio
        FROM producto_almacen INNER JOIN productos
        ON producto_almacen.id_producto = productos.id
        WHERE producto_almacen.estado = 1
        AND producto_almacen.stock > 0
        GROUP BY productos.id, productos.nombre, productos.descripcion, productos.precio;";

        $productos = DB::select($sql);
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
 
         return view('administracion.ventas.nota_venta',compact('productos','categorias','almacenes'));
    }

    public function store(Request $request){
       
        
             $venta = new Venta();
             $venta->fecha_hora        =  date('y-n-d h:i:s ');
             $venta->monto_total       =   Cart::getTotal();
             $venta->id_usuario      =  Auth::user()->id;
             $venta->save();
            $id_venta=$venta->id;
            $error =$this->guardardetalleVenta( $id_venta );
            
            $res['error'] = $error;
            return json_encode($res);
        
    }

    public function guardardetalleVenta($id_venta)
    { 
        try {
            foreach (\Cart::getContent() as $item) {
                $productalmacen = $this->producto_almacen->buscar_mi_almacen($item->id,$item->quantity);
                $detalle_venta = new DetalleVenta();
                $detalle_venta->id_productodealmacen   = $productalmacen['id'];
                $detalle_venta->id_venta               =  $id_venta ;
                $detalle_venta->cantidad               =  $item->quantity;
                $detalle_venta->subtotal               =  $item->getPriceSum();
                $detalle_venta->save();
                $this->producto_almacen->actualizaStockProductoAlmacen($productalmacen['id'], $item->id ,$item->quantity,'-');
            }
            $error = false;
            Cart::clear();
        } catch (\Throwable $th) {
            $error = true;
        }
        return  $error;
    }

    public function pdf_detalle($id_venta){
        $venta_nota= Venta::all()->where('id','=',$id_venta)->first();
        $mytime=$venta_nota->fecha_hora;
        $total=$venta_nota->monto_total;
        $ventas=DetalleVenta::select(
            'detalle_ventas.*',
            'productos.nombre as pnombre',
            'productos.precio'  
        )
        ->join('producto_almacen','detalle_ventas.id_productodealmacen','=','producto_almacen.id')
        ->join('productos','producto_almacen.id_producto','=','productos.id')
        ->join('almacenes','producto_almacen.id_almacen','=','almacenes.id')
        ->where('detalle_ventas.id_venta','=',$id_venta)
        ->get();
        $pdf = new Fpdf('P','mm',array(200,200));
            $sw=1;
            $contador = 1;
            $color=0;
            foreach ($ventas as $row){
                if ($sw==1){
                    $pdf->AddPage();
                    $pdf->SetMargins(5,5,5);
                    $pdf->SetTitle("Detalle Venta");
                    $pdf->SetFont('Arial','B',11);
                    $pdf->image(asset('vendor/adminlte/dist/img/AdminLTELogo.png'),5,4,9,8,'PNG');
                    $pdf->Cell(190,4,'',0,1,'C');
                    $pdf->Cell(190,4,'Nota De Detalle',0,1,'C');
                    $pdf->Ln(6);
                    $pdf->SetFont('Arial','B',10);
                    $pdf->SetFont('Arial','',9);
                    $pdf->SetFont('Arial','B',9);
                    $pdf->Cell(17,5,utf8_decode('Dirección: '),0,0,'L');
                    $pdf->SetFont('Arial','',9);
                    $pdf->Cell(50,5,'Pollos Montero Roca Chavez',0,1,'L');
                    $pdf->SetFont('Arial','B',9);
                    $pdf->Cell(22,5,utf8_decode('Fecha y hora: '),0,0,'L');
                    $pdf->SetFont('Arial','',9);
                    $pdf->Cell(50,5,$mytime,0,1,'L');
                    $pdf->SetFont('Arial','B',9);
                    $pdf->Cell(22,5,utf8_decode('Remitente: '),0,0,'L');
                    $pdf->SetFont('Arial','',9);
                    $pdf->Cell(50,5,''.Auth::user()->name.''.' '.''.Auth::user()->apellidos.'',0,1,'L');
                    $pdf->Cell(70,2,'',0,1,'C');
                   // $pdf->SetFont('Arial','',9); 
                    $pdf->SetFont('Arial','B',11);
                    $pdf->Ln(10);
                    $pdf->SetFillColor(2,157,116);//Fondo verde de celda
                    $pdf->SetTextColor(240, 255, 240); //Letra color blanco
                    $pdf->Cell(14,5,utf8_decode('Nº'),1,0,'L',true);
                    $pdf->Cell(50,5,utf8_decode('Nombre'),1,0,'L',true);
                    $pdf->Cell(20,5,utf8_decode('precio'),1,0,'L',true);
                    $pdf->Cell(20,5,utf8_decode('cantidad'),1,0,'L',true);
                    $pdf->MultiCell(43,5,utf8_decode('sub total'),1,1,'L',true);
                    $pdf->SetFont('Arial','',11);
                   // $pdf->Ln(5);
                    $sw=0;
                }

                if($color==1){
                $pdf->SetFillColor(229, 232, 232 ); //gris tenue de cada fila
                $pdf->SetTextColor(3, 3, 3); //Color del texto: Negro
                $color=0;
                }else{
                $pdf->SetFillColor(255, 255, 255 ); //blanco tenue de cada fila
                $pdf->SetTextColor(3, 3, 3); //Color del texto: Negro
                $color=1;
                }

                $pdf->Cell(14,5,$contador,'LR',0,'L',true);
                $pdf->Cell(50,5,$row['pnombre'],'LR',0,'L',true);
                $pdf->Cell(20,5,$row['precio'],'LR',0,'L',true);
                $pdf->Cell(20,5,$row['cantidad'],'LR',0,'L',true);
                $pdf->Cell(43,5,utf8_decode($row['subtotal']),'LR',1,'L',true); // L= IZQUIERDA R= DERECHA
              
                if ($contador%24==0){$sw=1;}
                $contador++;
            }
           
            $pdf->ln();
            $pdf->Cell(17,5,utf8_decode('Gracias por su compra: '),0,0,'L');
            $pdf->ln();
            $pdf->Cell(30,5,utf8_decode('Total a Pagar: '),0,0,'L');
            $pdf->SetFont('Arial','',9);
            $pdf->Cell(20,5,$total.' bs',0,1,'L');
            $pdf->Output('I','informe reporte.pdf');

    }

    public function delete($id){
        $venta= Venta::all()->where('id','=',$id)->first();
        $venta->estado=0;
        $venta->update();
        return redirect(route('venta.index'));
    }

    
}
