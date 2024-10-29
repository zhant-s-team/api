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
            $table->string('nome');
            $table->string('cpf');
            $table->string('email');
            $table->string('senha');
            $table->string('telefone');
            $table->date('data_nascimento');
            $table->string('cep');
            $table->string('estado');
            $table->string('bairro');
            $table->string('rua');
            $table->timestamps(); // Cria os campos created_at e updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('motoristas');
    }
}
