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
        // Cria uma tabela chamada 'motorista'
        Schema::create('motorista', function (Blueprint $table) {
            // Cria uma coluna 'id' do tipo inteiro que auto-incrementa e define-a como chave primária
            $table->increments('id'); // Chave primária auto-incrementável

            // Cria uma coluna 'nome' do tipo string com limite de 100 caracteres para armazenar o nome do motorista
            $table->string('nome', 100);

            // Cria uma coluna 'disponibilidade' do tipo string com limite de 20 caracteres para armazenar o status de disponibilidade do motorista (ex.: disponível, em serviço)
            $table->string('disponibilidade', 20);

            // Cria colunas 'created_at' e 'updated_at' para armazenar os timestamps de criação e atualização do registro
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove a tabela 'motorista' caso ela exista, revertendo a migração
        Schema::dropIfExists('motorista');
    }

};
