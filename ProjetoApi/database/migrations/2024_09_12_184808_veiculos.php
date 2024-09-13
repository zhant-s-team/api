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
        // Cria uma tabela chamada 'veiculos'
        Schema::create('veiculos', function (Blueprint $table) {
            // Cria uma coluna 'id' do tipo inteiro que auto-incrementa e define-a como chave primária
            $table->increments('id'); // Chave primária auto-incrementável

            // Cria uma coluna 'tipo' do tipo string com um limite de 50 caracteres para armazenar o tipo de veículo (ex.: ônibus, carro)
            $table->string('tipo', 50);

            // Cria uma coluna 'capacidade' do tipo inteiro para armazenar a capacidade máxima do veículo
            $table->integer('capacidade');

            // Cria uma coluna 'status' do tipo string com um limite de 20 caracteres para armazenar o status do veículo (ex.: ativo, inativo)
            $table->string('status', 20);

            // Cria uma coluna 'placa' do tipo string com um limite de 10 caracteres para armazenar a placa do veículo, e garante que o valor seja único
            $table->string('placa', 10)->unique();

            // Cria colunas 'created_at' e 'updated_at' para armazenar os timestamps de criação e atualização do registro
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove a tabela 'veiculos' caso ela exista, revertendo a migração
        Schema::dropIfExists('veiculos');
    }

};
