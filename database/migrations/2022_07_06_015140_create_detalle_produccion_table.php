<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleProduccionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_produccion', function (Blueprint $table) {
            // nullable()          ---> Acepta valores nulos
            // cascadeOnUpdate()   ---> Modifica id ambas colunas
            // cascadeOnDelete()   ---> si el id de tabla produccion se elimina entoces el id relacionada tambien (id:fila registro)
            $table->id();
            //RELACION MUCHOS A MUCHO (TABLA INTERMEDIA)
            $table->foreignId('id_producto')->nullable()->constrained('productos')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('id_produccion')->nullable()->constrained('produccion')->cascadeOnUpdate()->cascadeOnDelete();
            $table->integer('cantidad');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalle_produccion');
    }
}
