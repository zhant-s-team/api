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
        // Cria uma tabela chamada 'usuario'
        Schema::create('usuario', function (Blueprint $table) {
            // Cria uma coluna 'cpf' do tipo string com 11 caracteres, definindo-a como chave primária
            $table->string('cpf', 11)->primary(); // CPF como chave primária

            // Cria uma coluna 'nome' do tipo string com limite de 100 caracteres
            $table->string('nome', 100);

            // Cria uma coluna 'data de nascimento' do tipo inteiro com limite de 2 caracteres
            $table->String('data de nascimento', 10);

            // Cria uma coluna 'telefone' do tipo string com limite de 15 caracteres
            $table->string('telefone', 15);

            // Cria uma coluna 'cep' do tipo int com limite de 200 caracteres
            $table->date('data_de_nascimento');

            // Cria uma coluna 'endereco' do tipo string com limite de 200 caracteres
            $table->string('rua', 100);

            // Cria uma coluna 'endereco' do tipo string com limite de 200 caracteres
            $table->string('endereco', 200);

            // Cria uma coluna 'endereco' do tipo string com limite de 200 caracteres
            $table->string('complemento', 70);

            // Cria uma coluna 'endereco' do tipo string com limite de 200 caracteres
            $table->string('bairro', 70);

            // Cria uma coluna 'endereco' do tipo string com limite de 200 caracteres
            $table->string('cidade', 70);

            // Cria uma coluna 'endereco' do tipo string com limite de 200 caracteres
            $table->string('estado', 70);

            // Cria uma coluna 'email' do tipo string e garante que o valor seja único
            $table->string('email')->unique();

            // Cria uma coluna 'email_verified_at' do tipo timestamp que pode ser nula, usada para armazenar quando o email foi verificado
            $table->timestamp('email_verified_at')->nullable();

            // Cria uma coluna 'password' do tipo string para armazenar a senha do usuário
            $table->string('password');

            // Cria uma coluna para armazenar o token de "lembrar-me" (usado para login persistente)
            $table->rememberToken();

            // Cria colunas 'created_at' e 'updated_at' para armazenar os timestamps de criação e atualização do registro
            $table->timestamps();
        });

        // Cria uma tabela chamada 'password_reset_tokens' para gerenciar a recuperação de senha
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            // Cria uma coluna 'email' do tipo string e define como chave primária
            $table->string('email')->primary();

            // Cria uma coluna 'token' do tipo string para armazenar o token de recuperação de senha
            $table->string('token');

            // Cria uma coluna 'created_at' do tipo timestamp que pode ser nula, para armazenar quando o token foi criado
            $table->timestamp('created_at')->nullable();
        });

        // Cria uma tabela chamada 'sessions' para armazenar as sessões dos usuários
        Schema::create('sessions', function (Blueprint $table) {
            // Cria uma coluna 'id' do tipo string e define como chave primária para identificar a sessão
            $table->string('id')->primary();

            // Cria uma coluna 'user_id' como chave estrangeira para o ID do usuário que está na sessão, pode ser nula, e adiciona um índice
            $table->foreignId('user_id')->nullable()->index();

            // Cria uma coluna 'ip_address' do tipo string com até 45 caracteres para armazenar o IP do usuário, pode ser nula
            $table->string('ip_address', 45)->nullable();

            // Cria uma coluna 'user_agent' do tipo text para armazenar informações do navegador do usuário, pode ser nula
            $table->text('user_agent')->nullable();

            // Cria uma coluna 'payload' do tipo longText para armazenar dados adicionais da sessão
            $table->longText('payload');

            // Cria uma coluna 'last_activity' do tipo integer e adiciona um índice, para armazenar o timestamp da última atividade na sessão
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove a tabela 'usuario' caso ela exista
        Schema::dropIfExists('usuario');

        // Remove a tabela 'password_reset_tokens' caso ela exista
        Schema::dropIfExists('password_reset_tokens');

        // Remove a tabela 'sessions' caso ela exista
        Schema::dropIfExists('sessions');
    }

};
