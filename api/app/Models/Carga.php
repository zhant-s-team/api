<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carga extends Model
{
    use HasFactory;

    // Define a tabela associada a este model
    protected $table = 'cargas';

    // Define os campos que podem ser preenchidos em massa
    protected $fillable = [
        'remetente',
        'descricao',
        'peso',
        'tipo',
        'destinatario',
        'data_envio',
        'previsao_entrega'
    ];

    // Definindo os tipos de dados para os atributos
    protected $casts = [
        'data_envio' => 'datetime',
        'previsao_entrega' => 'datetime',
        'peso' => 'float',
    ];

    // Relações com outras tabelas podem ser adicionadas aqui, caso haja necessidade.
}
