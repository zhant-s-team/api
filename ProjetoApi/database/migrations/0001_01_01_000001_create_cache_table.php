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
        // Cria uma tabela chamada 'cache'
        Schema::create('cache', function (Blueprint $table) {
            // Cria uma coluna 'key' do tipo string que será usada como chave primária (não pode ser nula e é única)
            $table->string('key')->primary();

            // Cria uma coluna 'value' do tipo mediumText para armazenar o valor do cache, permitindo grandes quantidades de texto
            $table->mediumText('value');

            // Cria uma coluna 'expiration' do tipo inteiro para armazenar o tempo de expiração do cache em formato numérico
            $table->integer('expiration');
        });

        // Cria uma tabela chamada 'cache_locks'
        Schema::create('cache_locks', function (Blueprint $table) {
            // Cria uma coluna 'key' do tipo string que será usada como chave primária (não pode ser nula e é única)
            $table->string('key')->primary();

            // Cria uma coluna 'owner' do tipo string para armazenar o identificador do proprietário do bloqueio
            $table->string('owner');

            // Cria uma coluna 'expiration' do tipo inteiro para armazenar o tempo de expiração do bloqueio
            $table->integer('expiration');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove a tabela 'cache' se ela existir
        Schema::dropIfExists('cache');

        // Remove a tabela 'cache_locks' se ela existir
        Schema::dropIfExists('cache_locks');
    }

};
