<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViagensTable extends Migration
{
    public function up()
    {
        Schema::create('viagens', function (Blueprint $table) {
            $table->id(); // Cria a coluna id como chave primária
            $table->foreignId('rota_id')->constrained('rotas'); // Chave estrangeira para a tabela rotas
            $table->foreignId('veiculo_id')->constrained('veiculos'); // Chave estrangeira para a tabela veículos
            $table->foreignId('motorista_id')->constrained('motoristas'); // Chave estrangeira para a tabela motoristas (corrigido)
            $table->foreignId('cargas_id')->constrained('cargas'); // Chave estrangeira para a tabela cargas
            $table->dateTime('data_hora'); // Campo para a data e hora da viagem
            $table->string('status'); // Campo para o status da viagem
            $table->timestamps(); // Cria os campos created_at e updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('viagens'); // Remove a tabela ao desfazer a migration
    }
}
