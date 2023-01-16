<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultaServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consulta_servicios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_servicio')->nullable()->constrained('servicios')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('id_consulta')->nullable()->constrained('consultas')->cascadeOnUpdate()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consulta_servicios');
    }
}
