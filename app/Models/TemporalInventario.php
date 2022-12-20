<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporalInventario extends Model
{
    use HasFactory;
    protected $table = 'temporal_inventario';
    protected $primaryKey ='id';
    protected $fillable = [
        'folio',
        'id_producto',
        'id_almacen',
        'almacen',
        'producto',
        'descripcion',
        'precio',
        'stock'
    ];
    public $timestamps=false;
 
    public function porIdProductoAlmacen($id_producto,$id_almacen,$folio){
        $datos=$this->select('*')->where('folio','=',$folio)->where('id_producto','=',$id_producto)->where('id_almacen','=',$id_almacen)->get()->first(); 
        return $datos;
    }
    
    public function TraerDatosTempInv($folio){
        $datos =  $this->select('*')->where('folio','=',$folio)->get(); 
        return $datos;
       /* $datos=TemporalInventario::select('*')->where('folio','=',$folio)->get(); 
        return $datos;*/
     }

    public function vaciar_temporal_inventario(){
        $this->truncate();
    }

}
