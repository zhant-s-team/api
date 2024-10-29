<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motorista extends Model
{
    use HasFactory;

    // Define a tabela associada ao modelo
    protected $table = 'motoristas';

    protected $fillable = [
        'nome',
        'cpf',
        'email',
        'senha',
        'telefone',
        'data_nascimento',
        'cep',
        'estado',
        'bairro',
        'rua'
    ];

    // Indica que a chave primária não é auto-incrementável
    public $incrementing = true;

    // Especifica que o tipo da chave primária é inteiro
    protected $keyType = 'int';
}
