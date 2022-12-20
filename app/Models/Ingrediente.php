<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ingrediente extends Model
{
    use HasFactory;
    protected $table = 'ingredientes';
    protected $primaryKey ='id';
    protected $fillable = [
        'nombre',
        'descripcion',
        'id_provedor',
        'id_provedor',
        'estado',
    ];
    public $timestamps=false;
}
