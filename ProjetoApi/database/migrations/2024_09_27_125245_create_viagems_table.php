<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Cria uma tabela chamada 'viagem'
        Schema::create('viagem', function (Blueprint $table) {
            // Cria uma coluna 'id' do tipo inteiro que auto-incrementa e define-a como chave primária
            $table->increments('id'); // Chave primária auto-incrementável

            // Cria uma coluna 'rota_id' do tipo inteiro sem sinal para armazenar a chave estrangeira que faz referência à tabela 'rotas'
            $table->unsignedInteger('rota_id'); // Chave estrangeira para 'rotas'

            // Define 'rota_id' como chave estrangeira que referencia a coluna 'id' na tabela 'rotas'
            $table->foreign('rota_id')->references('id')->on('rotas');

            // Cria uma coluna 'veiculo_id' do tipo inteiro sem sinal para armazenar a chave estrangeira que faz referência à tabela 'veiculos'
            $table->unsignedInteger('veiculo_id'); // Chave estrangeira para 'veiculos'

            // Define 'veiculo_id' como chave estrangeira que referencia a coluna 'id' na tabela 'veiculos'
            $table->foreign('veiculo_id')->references('id')->on('veiculos');

            // Cria uma coluna 'motorista_id' do tipo inteiro sem sinal para armazenar a chave estrangeira que faz referência à tabela 'motoristas'
            $table->unsignedInteger('motorista_id'); // Chave estrangeira para 'motoristas'

            // Define 'motorista_id' como chave estrangeira que referencia a coluna 'id' na tabela 'motoristas'
            $table->foreign('motorista_id')->references('id')->on('motorista');

            // Cria uma coluna 'cargas_id' do tipo inteiro sem sinal para armazenar a chave estrangeira que faz referência à tabela 'cargas'
            $table->unsignedInteger('cargas_id'); // Chave estrangeira para 'viagem'

            // Define 'cargas_id' como chave estrangeira que referencia a coluna 'id' na tabela 'cargas'
            $table->foreign('cargas_id')->references('id')->on('cargas');

            // Cria uma coluna 'data_hora' do tipo dateTime para armazenar a data e a hora da viagem
            $table->dateTime('data_hora');

            // Cria uma coluna 'status' do tipo string com limite de 20 caracteres para armazenar o status da viagem (ex.: agendada, concluída)
            $table->string('status', 20);

            // Cria colunas 'created_at' e 'updated_at' para armazenar os timestamps de criação e atualização do registro
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove a tabela 'viagem' caso ela exista, revertendo a migração
        Schema::dropIfExists('viagem');
    }

};
