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
            'nombre' => 'royal canin',
            'descripcion' => 'puppy maxi para mascotas de 26-44kg',
            'precio' => 30,
            'stock' => 12,
            'estado' => 1,

            'id_categoria' => 1
        ]);
        DB::table('productos')->insert([
            'id' => '2',
            'nombre' => 'Royal canin',
            'descripcion' => 'Puppy mini para mascotas menos de 10kg',
            'precio' => 25,
            'stock' => 23,
            'estado' => 1,
            'id_categoria' => 1
        ]);
        DB::table('productos')->insert([
            'id' => '3',
            'nombre' => 'NexGard',
            'descripcion' => 'Para mascota de 10,1-25kg protege por 30dias',
            'precio' => 12.00,
            'stock' => 6,
            'estado' => 1,
            'id_categoria' => 2
        ]);
        DB::table('productos')->insert([
            'id' => '4',
            'nombre' => 'Hueso',
            'descripcion' => 'hueso especialmente para cachoros',
            'precio' => 13.0,
            'stock' => 12,
            'estado' => 1,
            'id_categoria' => 3
        ]);

        DB::table('productos')->insert([
            'id' => '5',
            'nombre' => 'arnes',
            'descripcion' => 'arnes para perros pequeños',
            'precio' => 14.0,
            'stock' => 20,
            'estado' => 1,
            'id_categoria' => 3
        ]);

    }
}
