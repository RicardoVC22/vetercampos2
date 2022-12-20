<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->date('fechaentrega');
            $table->float('montototal');
            $table->string('estadodelpedido',30)->default('pendiente');                                      // pendiente, entregado, cancelado
            $table->tinyInteger('estado')->default(1);

            $table->unsignedBigInteger('id_ubicacion')->nullable()->unique();           //uno a uno  : acepta valores null y debe ser unico
            $table->unsignedBigInteger('id_cliente');                                     //uno a muchos
            $table->unsignedBigInteger('id_empleado')->nullable()->default(null); //uno a muchos
            $table->unsignedBigInteger('id_repartidor')->nullable()->default(null); //uno a muchos
            $table->timestamps();
        
            // Relacionando tablas capturando llave primaria de categoria
            $table->foreign('id_ubicacion')->references('id')->on('ubicacion')->onDelete('cascade')->onUpdate('cascade'); //cascade: eliminao modifica el registro relacionado
            $table->foreign('id_cliente')->references('id')->on('clientes');
            $table->foreign('id_empleado')->references('id')->on('empleados');
            $table->foreign('id_repartidor')->references('id')->on('repartidores');
            // $table->foreign('id_curso')->references('id')->on('cursos')->onDelete('set null');
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pedidos');
    }
}
