<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemporalConsultasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temporal_consultas', function (Blueprint $table) {
            $table->id();
            $table->string('folio');
            $table->integer('id_consulta')->default(-1);
            $table->integer('id_servicio');
            $table->string('nombre');
            $table->string('descripcion');
            $table->float('precio');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('temporal_consultas');
    }
}
