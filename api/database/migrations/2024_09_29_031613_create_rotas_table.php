<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRotasTable extends Migration
{
    public function up()
    {
        Schema::create('rotas', function (Blueprint $table) {
            $table->id();
            $table->string('origem');
            $table->string('destino');
            $table->dateTime('data_hora');
            $table->text('paradas')->nullable();
            $table->timestamps(); 
        });
    }

    public function down()
    {
        Schema::dropIfExists('rotas'); 
    }
}
