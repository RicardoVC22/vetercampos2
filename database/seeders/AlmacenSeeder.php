<?php

namespace Database\Seeders;
use App\Models\Almacen;

use Illuminate\Database\Seeder;

class AlmacenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Almacen::create([
            'sigla'=>'A',
            'capacidad'=>1000, 
        ]);
        Almacen::create([
            'sigla'=>'B',
            'capacidad'=>1000, 
        ]);
        Almacen::create([
            'sigla'=>'C',
            'capacidad'=>1000, 
        ]);
        Almacen::create([
            'sigla'=>'D',
            'capacidad'=>1000, 
        ]);
        Almacen::create([
            'sigla'=>'E',
            'capacidad'=>1000, 
        ]);
          
    }
}
