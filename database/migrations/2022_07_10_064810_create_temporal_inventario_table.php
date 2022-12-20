<?php

use Facade\Ignition\Tabs\Tab;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemporalInventarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temporal_inventario', function (Blueprint $table) {
            $table->id();
            $table->string('folio');
            $table->integer('id_producto');
            $table->integer('id_almacen');
            $table->string('almacen',10);
            $table->string('producto');
            $table->string('descripcion');
            $table->float('precio');
            $table->integer('stock');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('temporal_inventario');
    }
}
