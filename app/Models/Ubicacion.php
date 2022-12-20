<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    use HasFactory;
    protected $table = 'ubicacion';
    protected $primaryKey ='id';
    protected $fillable = [
        'latitud',
        'longitud',
        'referencia',
        'url'
    ];
    public $timestamps=false;

  
    //UNO A UNO : Ayuda atraer el registro con los cual esta relacionado
    public function pedidos()
    {
        return $this->hasOne(Pedido::class);
    }
}
