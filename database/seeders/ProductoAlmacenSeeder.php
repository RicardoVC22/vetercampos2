<?php

namespace Database\Seeders;

use App\Models\ProductoAlmacen;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductoAlmacenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('producto_almacen')->insert([
            'id_producto' => '1',
            'id_almacen' => '1',
            'stock' => '300',
            'estado' => '1',
        ]);
        DB::table('producto_almacen')->insert([
            'id_producto' => '2',
            'id_almacen' => '2',
            'stock' => '300',
            'estado' => '1',
        ]);
        DB::table('producto_almacen')->insert([
            'id_producto' => '3',
            'id_almacen' => '2',
            'stock' => '300',
            'estado' => '1',
        ]);

    }
}
