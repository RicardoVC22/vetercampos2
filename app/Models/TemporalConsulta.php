<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporalConsulta extends Model
{
    use HasFactory;
    protected $table = 'temporal_consultas';
    protected $primaryKey ='id';
    protected $fillable = [
        'folio',
        'id_consulta',
        'id_servicio',
        'nombre',
        'descripcion',
        'precio'
    ];
    public $timestamps=false;

    public function porIdConsulta_Servicio($id_servicio,$folio){
        $datos=$this->select('*')->where('folio','=',$folio)->where('id_servicio','=',$id_servicio)->get()->first(); 
        return $datos;
    }
    
    public function TraerDatosTempConsulta($folio){
        $datos =  $this->select('*')->where('folio','=',$folio)->get(); 
        return $datos;
       /* $datos=TemporalInventario::select('*')->where('folio','=',$folio)->get(); 
        return $datos;*/
     }

    public function vaciar_temporal_consulta(){
        $this->truncate();
    }
}
