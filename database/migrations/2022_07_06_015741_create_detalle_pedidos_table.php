<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_pedidos', function (Blueprint $table) {
            // nullable()          ---> Acepta valores nulos
            // cascadeOnUpdate()   ---> Modifica id ambas colunas
            // nullOnDelete()      ---> si el id de tabla pedido se elimina entoces reemplazar la id relacionada por null
            $table->id();
            $table->foreignId('id_productodealmacen')->nullable()->constrained('producto_almacen')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('id_pedido')->nullable()->constrained('pedidos')->cascadeOnUpdate()->nullOnDelete(); //a
            $table->integer('cantidad');
            $table->float('subtotal',8,2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalle_pedidos');
    }
}
