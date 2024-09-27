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
        // Cria uma tabela chamada 'rotas'
        Schema::create('rotas', function (Blueprint $table) {
            // Cria uma coluna 'id' do tipo inteiro que auto-incrementa e define-a como chave primária
            $table->increments('id'); // Chave primária auto-incrementável

            // Cria uma coluna 'origem' do tipo string com limite de 100 caracteres para armazenar a cidade de origem
            $table->string('origem', 100);

            // Cria uma coluna 'destino' do tipo string com limite de 100 caracteres para armazenar a cidade de destino
            $table->string('destino', 100);

            // Cria uma coluna 'data_hora' do tipo DateTime para armazenar a data e hora da partida
            $table->dateTime('data_hora');

            // Cria uma coluna 'paradas' do tipo JSON para armazenar uma lista de paradas intermediárias na rota
            $table->json('paradas'); // Armazenar a lista de paradas como JSON

            // Cria colunas 'created_at' e 'updated_at' para armazenar os timestamps de criação e atualização do registro
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove a tabela 'rotas' caso ela exista, revertendo a migração
        Schema::dropIfExists('rotas');
    }

};
