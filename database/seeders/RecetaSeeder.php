<?php

namespace Database\Seeders;
use App\Models\ingrediente;

use Illuminate\Database\Seeder;

class RecetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ingrediente::create([
            'nombre'=>'agua',
            'descripcion'=>'-',
            'id_provedor'=>1   
        ]);
        ingrediente::create([
            'nombre'=>'huevo',
            'descripcion'=>'-',
            'id_provedor'=>5   
        ]);
        ingrediente::create([
            'nombre'=>'pollo sofia',
            'descripcion'=>'-',
            'id_provedor'=>3   
        ]);
        ingrediente::create([
            'nombre'=>'queso',
            'descripcion'=>'queso natural',
            'id_provedor'=>4   
        ]);
        ingrediente::create([
            'nombre'=>'harina broaster',
            'descripcion'=>'harina de freir',
            'id_provedor'=>4   
        ]);

        ingrediente::create([
            'nombre'=>'lechuga',
            'descripcion'=>'-',
            'id_provedor'=>2   
        ]);
        ingrediente::create([
            'nombre'=>'carne',
            'descripcion'=>'-',
            'id_provedor'=>6   
        ]);

        
    }
}
