<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMotoristasTable extends Migration
{
    public function up()
    {
        Schema::create('motoristas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->boolean('disponibilidade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('motoristas');
    }
}
