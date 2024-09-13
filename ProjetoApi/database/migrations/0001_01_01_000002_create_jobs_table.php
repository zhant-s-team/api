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
        // Cria uma tabela chamada 'jobs'
        Schema::create('jobs', function (Blueprint $table) {
            // Cria uma coluna 'id' como chave primária auto-incrementável
            $table->id();

            // Cria uma coluna 'queue' do tipo string para armazenar o nome da fila do job, com índice para melhorar a performance nas buscas
            $table->string('queue')->index();

            // Cria uma coluna 'payload' do tipo longText para armazenar os dados do job
            $table->longText('payload');

            // Cria uma coluna 'attempts' do tipo unsignedTinyInteger para armazenar o número de tentativas de execução do job
            $table->unsignedTinyInteger('attempts');

            // Cria uma coluna 'reserved_at' do tipo unsignedInteger que pode ser nula para armazenar o timestamp quando o job foi reservado
            $table->unsignedInteger('reserved_at')->nullable();

            // Cria uma coluna 'available_at' do tipo unsignedInteger para armazenar o timestamp quando o job estará disponível para execução
            $table->unsignedInteger('available_at');

            // Cria uma coluna 'created_at' do tipo unsignedInteger para armazenar o timestamp de criação do job
            $table->unsignedInteger('created_at');
        });

        // Cria uma tabela chamada 'job_batches'
        Schema::create('job_batches', function (Blueprint $table) {
            // Cria uma coluna 'id' do tipo string como chave primária
            $table->string('id')->primary();

            // Cria uma coluna 'name' do tipo string para armazenar o nome do lote de jobs
            $table->string('name');

            // Cria uma coluna 'total_jobs' do tipo integer para armazenar o total de jobs no lote
            $table->integer('total_jobs');

            // Cria uma coluna 'pending_jobs' do tipo integer para armazenar a quantidade de jobs pendentes
            $table->integer('pending_jobs');

            // Cria uma coluna 'failed_jobs' do tipo integer para armazenar a quantidade de jobs que falharam
            $table->integer('failed_jobs');

            // Cria uma coluna 'failed_job_ids' do tipo longText para armazenar os IDs dos jobs que falharam
            $table->longText('failed_job_ids');

            // Cria uma coluna 'options' do tipo mediumText para armazenar opções adicionais do lote, podendo ser nula
            $table->mediumText('options')->nullable();

            // Cria uma coluna 'cancelled_at' do tipo integer para armazenar o timestamp quando o lote foi cancelado, podendo ser nula
            $table->integer('cancelled_at')->nullable();

            // Cria uma coluna 'created_at' do tipo integer para armazenar o timestamp de criação do lote
            $table->integer('created_at');

            // Cria uma coluna 'finished_at' do tipo integer para armazenar o timestamp quando o lote foi finalizado, podendo ser nula
            $table->integer('finished_at')->nullable();
        });

        // Cria uma tabela chamada 'failed_jobs'
        Schema::create('failed_jobs', function (Blueprint $table) {
            // Cria uma coluna 'id' como chave primária auto-incrementável
            $table->id();

            // Cria uma coluna 'uuid' do tipo string e garante que seja única
            $table->string('uuid')->unique();

            // Cria uma coluna 'connection' do tipo text para armazenar o nome da conexão onde o job falhou
            $table->text('connection');

            // Cria uma coluna 'queue' do tipo text para armazenar o nome da fila onde o job falhou
            $table->text('queue');

            // Cria uma coluna 'payload' do tipo longText para armazenar os dados do job que falhou
            $table->longText('payload');

            // Cria uma coluna 'exception' do tipo longText para armazenar a exceção gerada pelo job que falhou
            $table->longText('exception');

            // Cria uma coluna 'failed_at' do tipo timestamp e define que será preenchida com a data e hora atual por padrão
            $table->timestamp('failed_at')->useCurrent();
        });
    }

/**
 * Reverse the migrations.
 */
public function down(): void
{
    // Remove a tabela 'jobs' caso ela exista
    Schema::dropIfExists('jobs');

    // Remove a tabela 'job_batches' caso ela exista
    Schema::dropIfExists('job_batches');

    // Remove a tabela 'failed_jobs' caso ela exista
    Schema::dropIfExists('failed_jobs');
}

};
