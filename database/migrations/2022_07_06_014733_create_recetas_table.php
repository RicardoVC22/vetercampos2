<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recetas', function (Blueprint $table) {
            $table->id();
            //RELACION MUCHOS A MUCHOS (TABLA INTERMEDIA)
            $table->foreignId('id_ingrediente')->nullable()->constrained('ingredientes')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('id_producto')->nullable()->constrained('productos')->cascadeOnUpdate()->nullOnDelete();
            $table->integer('cantidad');
            $table->string('unidad');
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
        Schema::dropIfExists('recetas');
    }
}
