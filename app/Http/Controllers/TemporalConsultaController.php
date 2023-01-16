<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use App\Models\TemporalConsulta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TemporalConsultaController extends Controller
{
    protected $temporal_consulta;
    
    public function __construct()
    {
        $this->temporal_consulta = new TemporalConsulta();
    }

    public function insertar( Request $request){

        $rules=array(
            'id_servicio'  =>"required|numeric",
            'folio' =>"required",
        );
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            return [
                'message' => 'error',
                'errors' =>$validator->getMessageBag()->toArray()
            ];
        }
        else{
           
            $error='';
            $id_servicio    =   $request->id_servicio;
            $folio  =   $request->folio;
            //$id_consulta     =   $request->id_consulta;

            $servicio = Servicio::findOrFail($id_servicio);
    
            if($servicio){
              
                $datosExiste = $this->temporal_consulta->porIdConsulta_Servicio($id_servicio,$folio);

                if ($datosExiste){
                    
                  
                }else{
                    $dato = New TemporalConsulta();
                    $dato->folio        = $folio;
                    $dato->id_servicio  = $id_servicio;
                    $dato->nombre       = $servicio['nombre'];
                    $dato->descripcion  = $servicio['descripcion'];
                    $dato->precio       = $servicio['precio'];
                    $dato->save();
                }

            }else{
                $error = 'No existe el producto';
            }
           
        $res['datos'] = $this->cargaProductosenConsulta($folio);
   
        $res['error'] = $error;

        return json_encode($res);
        }

    }

    public function cargaProductosenConsulta($folio)
    {
        $resultado = $this->temporal_consulta->TraerDatosTempConsulta($folio);
        $fila = '';
        $numFila = 0;
        foreach ($resultado as $row){
            $numFila++;
            $fila .= "<tr id='fila".$numFila."'>";
            $fila .= "<td>".$numFila."</td>";
            $fila .= "<td>".$row['nombre']."</td>";
            $fila .= "<td>".$row['descripcion']."</td>";
            $fila .= "<td>".$row['precio']."</td>";
            $fila .= "<td><a role = 'button' onclick=\"eliminaServicio(".$row['id'].")\" class='borrar' ><span  class='fas fa-fw fa-trash'></span></a></td>";
            $fila .= "</tr>";
        }
        return $fila;
    }

    public function eliminar($id)
    {
        $datosExiste = TemporalConsulta::findOrFail($id);
      
        if ($datosExiste){
            if ($datosExiste->stock > 1){
                $stockactual= $datosExiste->stock - 1;
                $datosExiste->stock = $stockactual;
                $datosExiste->update();
            }else {
                $datosExiste->delete();
            }
        }
        $res['datos'] = $this->cargaProductosenConsulta( $datosExiste->folio);
        $res['error']=$datosExiste->folio;
        return json_encode($res);
    }

    public function vaciar()
    {
        TemporalInventario::truncate();
    }
}
