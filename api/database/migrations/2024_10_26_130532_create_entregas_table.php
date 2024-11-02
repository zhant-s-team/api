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
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('titulo');
            $table->text('descricao');
            $table->string('cidade_origem');
            $table->string('cidade_destino');
            $table->enum('tipo_veiculo', [
                'TC','BT','RT','BU','TQ'
            ]);
            $table->string('carga');
            $table->integer('percurso');
            $table->enum('status', ['D', 'A', 'C '])->default('D');
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
