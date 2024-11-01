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
        Schema::create('entregas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('empresa_id')->constrained()->cascadeOnDelete();
            $table->foreignId('motorista_id')->nullable()->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('user_id'); // Adicionando a coluna user_id
            $table->string('titulo');
            $table->text('descricao');
            $table->string('cidade_origem');
            $table->string('cidade_destino');
            $table->enum('tipo_veiculo', [
                'Toco',
                'Truck',
                'Bitrem',
                'Rodotrem',
                'Carreta LS',
                'Carreta Baú',
                'Carreta Graneleira',
                'Caçamba',
                'Romeu e Julieta',
                'Caminhão 3/4',
                'Porta-contêiner'
            ]);
            $table->string('carga');
            $table->integer('percurso');
            $table->enum('status', ['disponivel', 'em_andamento', 'concluido'])->default('disponivel');

            // Chave estrangeira para a tabela users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entregas');
    }
};
