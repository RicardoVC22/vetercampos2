<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class provedor extends Model
{
    protected $table = 'provedores';
    protected $primaryKey ='id';
    protected $fillable = [
        'direccion',
        'telefono',
        'correo',
    ];
    use HasFactory;
}
