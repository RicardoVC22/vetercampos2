<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductoAlmacenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto_almacen', function (Blueprint $table) {
            //RELACION MUCHOS A MUCHOS (TABLA INTERMEDIA)
            $table->id();
            $table->foreignId('id_producto')->nullable()->constrained('productos')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('id_almacen')->nullable()->constrained('almacenes')->cascadeOnUpdate()->nullOnDelete();
            $table->integer('stock');
            $table->integer('estado')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('producto_almacen');
    }
}
