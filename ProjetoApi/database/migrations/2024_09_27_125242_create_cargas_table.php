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
        Schema::create('cargas', function (Blueprint $table) {
            $table->increments('id'); // Chave primária auto-incrementável
            $table->string('remetente'); // Cria a coluna remetente
            $table->string('descricao', 255); // Descrição da carga
            $table->float('peso'); // Peso da carga
            $table->string('tipo', 50); // Tipo da carga (perecível, perigosa, etc.)
            $table->string('destinatario', 100); // Nome do destinatário da carga

            // Data de envio e previsão de entrega
            $table->dateTime('data_envio');
            $table->dateTime('previsao_entrega');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cargas');
    }
};
