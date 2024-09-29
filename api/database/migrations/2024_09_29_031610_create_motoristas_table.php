<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMotoristasTable extends Migration
{
    public function up()
    {
        Schema::create('motoristas', function (Blueprint $table) {
            $table->id(); // Cria a coluna id como chave primária
            $table->string('nome'); // Campo para o nome do motorista
            $table->boolean('disponibilidade'); // Campo para a disponibilidade do motorista
            $table->timestamps(); // Cria os campos created_at e updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('motoristas'); // Remove a tabela ao desfazer a migration
    }
}
