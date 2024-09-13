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
        // Cria uma tabela chamada 'passagem'
        Schema::create('passagem', function (Blueprint $table) {
            // Cria uma coluna 'id' do tipo inteiro que auto-incrementa e define-a como chave primária
            $table->increments('id'); // Chave primária auto-incrementável

            // Cria uma coluna 'nome_passageiro' do tipo string com limite de 100 caracteres para armazenar o nome do passageiro
            $table->string('nome_passageiro', 100);

            // Cria uma coluna 'rota_id' do tipo inteiro sem sinal para armazenar a chave estrangeira referenciando a tabela 'rotas'
            $table->unsignedInteger('rota_id'); // Chave estrangeira para 'rotas'

            // Define 'rota_id' como chave estrangeira que referencia a coluna 'id' da tabela 'rotas'
            $table->foreign('rota_id')->references('id')->on('rotas');

            // Cria uma coluna 'data_hora' do tipo DateTime para armazenar a data e hora da viagem
            $table->dateTime('data_hora');

            // Cria uma coluna 'assento' do tipo inteiro para armazenar o número do assento do passageiro
            $table->integer('assento');

            // Cria colunas 'created_at' e 'updated_at' para armazenar os timestamps de criação e atualização do registro
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove a tabela 'passagem' caso ela exista, revertendo a migração
        Schema::dropIfExists('passagem');
    }

};
