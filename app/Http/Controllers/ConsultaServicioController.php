<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Consulta;
use App\Models\ConsultaServicio;
use App\Models\Servicio;
use App\Models\TemporalConsulta;
use Illuminate\Http\Request;

class ConsultaServicioController extends Controller
{
    protected $temporal_consulta;
   
    public function __construct()
    {
        $this->temporal_consulta = new TemporalConsulta();
    }

    public function index()
    {
        
    }

    public function create($id_consulta)
    {
        $servicios = Servicio::all()->where('estado',1);
        $clientes = Cliente::all()->where('estado',1);
        
        return view('administracion.consulta_servicio.create',compact('servicios','clientes','id_consulta'));
    }

    public function buscar($id)
    {
        $datos = Servicio::findOrFail($id);
        $res['messege']='hola como te llamas';
        $res['id']=$id;
        $res['datos']=$datos;
        return json_encode($res);
    }

    public function store(Request $request)
    {
        $folio = $request->id_folio;
        $id_consulta =  $request->id_consulta;
        $datos_del_temporal = $this->temporal_consulta->TraerDatosTempConsulta($folio);
        $precio_total=0;
        foreach ($datos_del_temporal as $row) {

            //$exite_producto_almacen = $this->producto_almacen->porIdProductoAlmacen($row['id_producto'],$row['id_almacen']);
                $consultaservicio = new ConsultaServicio();
                $consultaservicio->id_servicio = $row['id_servicio'];
                $consultaservicio->id_consulta = $id_consulta;
                $consultaservicio->save();
                $precio_total+=$row['precio'];
        }
        $consulta=Consulta::findOrFail($id_consulta);
        $consulta->monto_servicio=$precio_total;
        $consulta->vigencia=2;
        $consulta->update();
        $this->temporal_consulta->vaciar_temporal_consulta();

        return redirect('consulta');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ConsultaServicio  $consultaServicio
     * @return \Illuminate\Http\Response
     */
    public function show(ConsultaServicio $consultaServicio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ConsultaServicio  $consultaServicio
     * @return \Illuminate\Http\Response
     */
    public function edit(ConsultaServicio $consultaServicio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ConsultaServicio  $consultaServicio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ConsultaServicio $consultaServicio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ConsultaServicio  $consultaServicio
     * @return \Illuminate\Http\Response
     */
    public function destroy(ConsultaServicio $consultaServicio)
    {
        //
    }
}
