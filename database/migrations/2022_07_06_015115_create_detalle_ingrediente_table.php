<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleIngredienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_ingrediente', function (Blueprint $table) {
            $table->id();
            //RELACION MUCHOS A MUCHO (TABLA INTERMEDIA)
            $table->foreignId('id_produccion')->nullable()->constrained('produccion')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('id_ingrediente')->nullable()->constrained('ingredientes')->cascadeOnUpdate()->nullOnDelete();
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
        Schema::dropIfExists('detalle_ingrediente');
    }
}
