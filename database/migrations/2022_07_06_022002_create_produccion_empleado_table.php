<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduccionEmpleadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produccion_empleado', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_produccion')->nullable()->constrained('produccion')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('id_empleado')->nullable()->constrained('empleados')->cascadeOnUpdate()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produccion_empleado');
    }
}
