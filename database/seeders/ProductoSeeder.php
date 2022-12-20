<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; //AGREGAMOS ESTA LIBRERIA

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('productos')->insert([
            'id' => '1',
            'nombre' => 'cuadril',
            'descripcion' => 'Casero',
            'precio' => 10,
            'stock' => 12,
            'estado' => 1,
        
            'id_categoria' => 3
        ]);
        DB::table('productos')->insert([
            'id' => '2',
            'nombre' => 'milanesa',
            'descripcion' => 'Casero',
            'precio' => 15.50,
            'stock' => 23,
            'estado' => 1,
            'id_categoria' => 3
        ]);
        DB::table('productos')->insert([
            'id' => '3',
            'nombre' => 'pollo a la brasa',
            'descripcion' => 'Casero',
            'precio' => 12.00,
            'stock' => 6,
            'estado' => 1,
            'id_categoria' => 3
        ]);
        DB::table('productos')->insert([
            'id' => '4',
            'nombre' => 'pollo broaster',
            'descripcion' => 'hecho a aceite vegetal',
            'precio' => 13.0,
            'stock' => 12,
            'estado' => 1,
            'id_categoria' => 3
        ]);

        DB::table('productos')->insert([
            'id' => '5',
            'nombre' => 'Coca Cola 2 L',
            'descripcion' => 'pepsi',
            'precio' => 14.0,
            'stock' => 20,
            'estado' => 1,
            'id_categoria' => 4
        ]);

    }
}
