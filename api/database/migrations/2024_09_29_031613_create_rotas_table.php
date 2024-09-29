<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRotasTable extends Migration
{
    public function up()
    {
        Schema::create('rotas', function (Blueprint $table) {
            $table->id(); // Cria a coluna id como chave primária
            $table->string('origem'); // Campo para a origem da rota
            $table->string('destino'); // Campo para o destino da rota
            $table->dateTime('data_hora'); // Campo para a data e hora da rota
            $table->text('paradas')->nullable(); // Campo para as paradas, pode ser nulo
            $table->timestamps(); // Cria os campos created_at e updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('rotas'); // Remove a tabela ao desfazer a migration
    }
}
