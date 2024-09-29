<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motorista extends Model
{
    use HasFactory;

    // Define a tabela associada ao modelo
    protected $table = 'motoristas';

    // Permite a atribuição em massa para os campos especificados
    protected $fillable = ['nome', 'disponibilidade'];

    // Indica que a chave primária não é auto-incrementável
    public $incrementing = true;

    // Especifica que o tipo da chave primária é inteiro
    protected $keyType = 'int';
}
