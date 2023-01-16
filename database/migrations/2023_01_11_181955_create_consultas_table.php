<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultas', function (Blueprint $table) {
            $table->id();
            $table->float('monto_consulta')->default(0.0);
            $table->float('monto_servicio')->default(0.0);
            $table->string('descripcion');
            $table->integer('estado')->default(1);
            $table->integer('vigencia')->default(0);
            $table->foreignId('id_usuario')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('id_cliente')->nullable()->constrained('clientes')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('id_mascota')->nullable()->constrained('mascotas')->cascadeOnUpdate()->nullOnDelete();
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
        Schema::dropIfExists('consultas');
    }
}
