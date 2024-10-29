<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViagensTable extends Migration
{
    public function up()
    {
        Schema::create('viagens', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('rota_id')->constrained('rotas'); 
            $table->foreignId('veiculo_id')->constrained('veiculos'); 
            $table->foreignId('motorista_id')->constrained('motoristas'); 
            $table->foreignId('cargas_id')->constrained('cargas');
            $table->dateTime('data_hora'); 
            $table->string('status'); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('viagens'); 
    }
}
