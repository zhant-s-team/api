<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    // Define a tabela associada ao modelo
    protected $table = 'usuario';

    // Define a chave primária da tabela
    protected $primaryKey = 'cpf';

    // Define se a chave primária é auto-incrementável ou não (não é, no caso do CPF)
    public $incrementing = false;

    // Define o tipo da chave primária (string, já que o CPF é um campo de texto)
    protected $keyType = 'string';

    // Permite a atribuição em massa para os campos especificados
    protected $fillable = [
        'cpf',
        'nome',
        'telefone',
        'endereco',
        'email',
        'password',
    ];

    // Oculta determinados atributos quando o modelo é serializado (ex: para não expor a senha)
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relacionamentos com outras tabelas, se aplicável
    // Por exemplo, caso o usuário tenha uma relação com outra tabela, como 'viagens' ou 'passagens':

    // public function viagens()
    // {
    //     return $this->hasMany(Viagem::class);
    // }

    // public function passagens()
    // {
    //     return $this->hasMany(Passagem::class);
    // }
}
