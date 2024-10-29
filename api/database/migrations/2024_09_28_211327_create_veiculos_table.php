<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVeiculosTable extends Migration
{
    public function up()
    {
        Schema::create('veiculos', function (Blueprint $table) {
            $table->id();
            $table->string('tipo'); 
            $table->float('capacidade');
            $table->string('status');
            $table->string('placa');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('veiculos');
    }
}
