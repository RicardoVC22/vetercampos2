<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Consulta;
use App\Models\ConsultaServicio;
use App\Models\Mascota;
use App\Models\User;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsultaController extends Controller
{
 
    public function index()
    {
        $usuarios= User::all();
        $clientes= Cliente::all();
        $consultas = Consulta::all()->where('estado',1);
        return view('administracion.consulta.index',compact('consultas','usuarios','clientes'));
    }

    
    public function create()
    {
        $clientes= Cliente::all();
        return view('administracion.consulta.create',compact('clientes'));
    }

    public function mascota_add($id)
    {
        $consulta= Consulta::all()->where('id','=',$id)->first();
        $mascotas= Mascota::all()->where('id_cliente','=',$consulta->id_cliente);
        $id_consulta=$id;
        return view('administracion.consulta.add_mascota',compact('mascotas','id_consulta'));
    }

    public function mascota_store(Request $request)
    {
        $consulta= Consulta::all()->where('id','=',$request->id_consulta)->first();
        $consulta->id_mascota=$request->id_mascota;
        $consulta->vigencia=1;
        $consulta->update();

        return redirect('consulta'); 
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([  
            'descripcion'=>'required',
            'id_cliente'=>'required'
        ]);
        $consulta = new Consulta();
        $consulta->descripcion = $request->descripcion;
        $consulta->monto_consulta = 100;
        $consulta->id_usuario = Auth::user()->id;
        $consulta->id_cliente = $request->id_cliente;
        $consulta->save();
        return redirect('consulta'); 
    }



    public function pdf_detalle($id_consulta){
        $consulta_nota= Consulta::all()->where('id','=',$id_consulta)->first();
        $mytime=$consulta_nota->created_at;
        $total=$consulta_nota->monto_servicio;
        $mascota= Mascota::all()->where('id','=',$consulta_nota->id_mascota)->first();
        $nombre_mascota=$mascota->nombre;
        $ventas=ConsultaServicio::select(
            'consulta_servicios.*',
            'servicios.nombre as pnombre',
            'servicios.precio',
            'servicios.descripcion'  
        )
        
        ->join('servicios','consulta_servicios.id_servicio','=','servicios.id')
        ->join('consultas','consulta_servicios.id_consulta','=','consultas.id')
        ->where('consulta_servicios.id_consulta','=',$id_consulta)
        ->get();
        $pdf = new Fpdf('P','mm',array(200,200));
            $sw=1;
            $contador = 1;
            $color=0;
            foreach ($ventas as $row){
                if ($sw==1){
                    $pdf->AddPage();
                    $pdf->SetMargins(5,5,5);
                    $pdf->SetTitle("Detalle Consulta");
                    $pdf->SetFont('Arial','B',11);
                    $pdf->image(asset('vendor/adminlte/dist/img/AdminLTELogo.png'),5,4,9,8,'PNG');
                    $pdf->Cell(190,4,'',0,1,'C');
                    $pdf->Cell(190,4,'Nota De Consulta',0,1,'C');
                    $pdf->Ln(6);
                    
                    $pdf->SetFont('Arial','B',10);
                    $pdf->SetFont('Arial','',9);
                    $pdf->SetFont('Arial','B',9);
                    $pdf->Cell(17,5,utf8_decode('Dirección: '),0,0,'L');
                    $pdf->SetFont('Arial','',9);
                    $pdf->Cell(50,5,'Veterinaria',0,1,'L');
                    $pdf->SetFont('Arial','B',9);
                    $pdf->Cell(22,5,utf8_decode('Fecha y hora: '),0,0,'L');
                    $pdf->SetFont('Arial','',9);
                    $pdf->Cell(50,5,$mytime,0,1,'L');
                    $pdf->SetFont('Arial','B',9);
                    $pdf->Cell(22,5,utf8_decode('Remitente: '),0,0,'L');
                    $pdf->SetFont('Arial','',9);
                    $pdf->Cell(50,5,''.Auth::user()->name.''.' '.''.Auth::user()->apellidos.'',0,1,'L');
                    $pdf->SetFont('Arial','B',9);
                    $pdf->Cell(190,5,utf8_decode('diagnostico: '.$nombre_mascota),0,1,'C');
                    $pdf->Ln();
                    $pdf->SetFont('Arial','',9);
                    $pdf->Cell(190,5,utf8_decode($consulta_nota->descripcion),0,1,'C');
                    $pdf->Ln();
                    $pdf->Cell(70,2,'',0,1,'C');
                   // $pdf->SetFont('Arial','',9); 
                    $pdf->SetFont('Arial','B',11);
                    $pdf->Ln(10);
                    $pdf->SetFillColor(2,157,116);//Fondo verde de celda
                    $pdf->SetTextColor(240, 255, 240); //Letra color blanco
                    $pdf->Cell(14,5,utf8_decode('Nº'),1,0,'L',true);
                    $pdf->Cell(50,5,utf8_decode('Nombre'),1,0,'L',true);
                    $pdf->Cell(80,5,utf8_decode('descripcion'),1,0,'L',true);
                    $pdf->Cell(20,5,utf8_decode('precio'),1,1,'L',true);
                    
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
                $pdf->Cell(80,5,$row['descripcion'],'LR',0,'L',true);
                $pdf->Cell(20,5,$row['precio'],'LR',1,'L',true);
                
              
                if ($contador%24==0){$sw=1;}
                $contador++;
            }

            
        
            $pdf->ln();
            $pdf->Cell(17,5,utf8_decode(''),0,0,'L');
            $pdf->ln();
            $pdf->Cell(40,5,utf8_decode('Total a Pagar servicios: '),0,0,'L');
            $pdf->SetFont('Arial','',9);
            $pdf->Cell(20,5,$total.' bs',0,1,'L');
            $pdf->SetFont('Arial','',11);
            $pdf->Cell(37,5,utf8_decode('Total pagar Consulta: '),0,0,'L');
            $pdf->SetFont('Arial','',9);
            $pdf->Cell(20,5,$consulta_nota->monto_consulta.' bs',0,1,'L');
            $pdf->ln();
            $pdf->Output('I','informe reporte.pdf');

    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Consulta  $consulta
     * @return \Illuminate\Http\Response
     */
    public function show(Consulta $consulta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Consulta  $consulta
     * @return \Illuminate\Http\Response
     */
    public function edit(Consulta $consulta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Consulta  $consulta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Consulta $consulta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Consulta  $consulta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Consulta $consulta)
    {
        //
    }
}
