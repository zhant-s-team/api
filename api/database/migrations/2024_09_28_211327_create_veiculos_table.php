<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVeiculosTable extends Migration
{
    public function up()
    {
        Schema::create('veiculos', function (Blueprint $table) {
            $table->id(); // Cria um campo de ID auto-incremental
            $table->string('tipo'); // Campo para tipo do veículo
            $table->float('capacidade'); // Campo para capacidade do veículo
            $table->string('status'); // Campo para status do veículo
            $table->string('placa'); // Campo para placa do veículo
            $table->timestamps(); // Campos created_at e updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('veiculos');
    }
}
